<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFee;
use App\Models\Onsite;
use App\Models\OnsiteDocument;
use App\Models\ListDropdown;
use Illuminate\Http\Request;
use App\Http\Requests\OnsiteRequest;
use App\Http\Resources\OnsiteResource;

class OnsiteController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Onsites/Index',[
                    'colleges' => $this->colleges(),
                    'graduates' => $this->graduates(),
                    'types' => $this->types(),
                    'fees' => $this->fees(),
                ]);
        }
    }

    private function lists($request){
        $data = OnsiteResource::collection(
            Onsite::query()
            ->with('user.profile','status')
            ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')
            ->when($request->status, function ($query, $status) {
                $query->where('status_id', $status);
            })
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code', 'LIKE', "%{$keyword}%")->orWhere('name', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function store(OnsiteRequest $request){
        $data = Onsite::create(array_merge($request->all(),[
            'code' => 'ONSITE-'.date('m').date('Y').'-'.str_pad((Onsite::count()+1), 4, '0', STR_PAD_LEFT),
            'status_id' => 7,
            'user_id' => \Auth::user()->id
        ]));
        if($data){
            $total = 0;
            foreach($request->checked as $list){
                $document_fee = DocumentFee::where('document_id',$list['value'])->where('type_id',$request->is_express)->first();
                $data->lists()->create([
                    'status_id' => 12,
                    'quantity' => $list['quantity'],
                    'document_id' => $list['value']
                ]);
                $total += str_replace(['₱ ', '₱', ',', ' '], '', $document_fee->fee)*(int) $list['quantity'];
            }
            $data->total = $total;
            $data->save();
        }
        return back()->with([
            'data' => $data,
            'message' => 'Onsite request was created.',
            'info' => 'You\'ve successfully created new request.',
            'status' => true,
        ]);
    }

    public function update(Request $request){
        $data = Onsite::where('id',$request->id)->update([
            'status_id' => ($request->status == 'completed') ? 13 : 14,
            'id' => $request->id,
            'claimed_at' => ($request->status != 'completed') ? now() : null,
        ]);
        
        $data = Onsite::with('user.profile','status')
        ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')
        ->where('id',$request->id)->first();
        
        return back()->with([
            'data' => $data,
            'message' => 'Status updated',
            'info' => 'You\'ve successfully updated the onsite.',
            'status' => true,
        ]);
    }


    private function colleges(){
        $data = Document::with('name','type','fees','addons')->where('type_id',2)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name->name,
                'fees' => $item->fees,
                'is_primary' => $item->is_primary
            ];
        });
        return $data;
    }

    private function graduates(){
        $data = Document::with('name','type','fees','addons')->where('type_id',3)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name->name,
                'fees' => $item->fees,
                'is_primary' => $item->is_primary
            ];
        });
        return $data;
    }

    private function types(){
        $data = ListDropdown::where('classification','Document Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    private function fees(){
        $data = ListDropdown::where('classification','Fee Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'others' => $item->others
            ];
        });
        return $data;
    }
}
