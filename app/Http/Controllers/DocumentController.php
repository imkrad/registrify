<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFee;
use App\Models\ListName;
use App\Models\ListDropdown;
use Illuminate\Http\Request;
use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentResource;


class DocumentController extends Controller
{
    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->lists($request);
            break;
            default: 
                return inertia('Documents/Index',[
                    'documents' => $this->doc_types(),
                    'fees' => $this->fee_types(),
                    'names' => $this->names(),
                    'subnames' => $this->subnames()
                ]);
        }
    }

    private function lists($request){
        $data = DocumentResource::collection(
            Document::query()
            ->with('type','name','fees.addons.lists.name','addons.lists.name')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('name',function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type_id',$type);
            })
            ->orderBy('created_at','DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    private function fee_types(){
        $data = ListDropdown::where('classification','Fee Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'others' => $item->others
            ];
        });
        return $data;
    }

    private function doc_types(){
        $data = ListDropdown::where('classification','Document Type')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'others' => $item->others
            ];
        });
        return $data;
    }

    private function names(){
        $data = ListName::where('is_document',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'subname' => $item->subname
            ];
        });
        return $data;
    }

    private function subnames(){
        $data = ListName::where('is_addon',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'subname' => $item->subname
            ];
        });
        return $data;
    }

    public function store(DocumentRequest $request){
        if($request->option == 'addon'){
            if($request->type == 'fee'){
                $data = DocumentFee::findOrFail($request->id);
            }else{
                $data = Document::findOrFail($request->id);
            }
            $addons = $data->addons()->create([
                'fee' => $request->fee
            ]);
            if($addons){
                foreach($request->lists as $list){
                    $addons->lists()->create([
                        'quantity' => 1,
                        'name_id' => $list['value']
                    ]);
                }
            }
            return back()->with([
                'data' => $data,
                'message' => 'Document was created.',
                'info' => 'You\'ve successfully created the new document.',
                'status' => true,
            ]);
        }else{
            $data = Document::create($request->all());
            if($data){
                foreach($request->fees as $fee){
                    $data->fees()->create([
                        'fee' => $fee['amount'],
                        'type_id' => $fee['type_id']
                    ]);
                }
            }
            return back()->with([
                'data' => $data,
                'message' => 'Document was created.',
                'info' => 'You\'ve successfully created the new document.',
                'status' => true,
            ]);
        }
    }

    public function update(Request $request){
        $data = Document::find($request->id);
        if($data){
            foreach($request->fees as $fee){
                $feeAmount = trim(str_replace(',', '', $fee['amount']), '₱');
                $fee = DocumentFee::where('id',$fee['id'])->update(['fee' => $feeAmount]);
            }
        }
        $data =  Document::with('type','name','fees')->where('id',$request->id)->first();
        return back()->with([
            'data' =>  new DocumentResource($data),
            'message' => 'User update was successful!', 
            'info' => "You've successfully update user profile.",
            'status' => true
        ]);
    }
}
