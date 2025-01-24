<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\ListMenu;
use App\Models\Student;
use App\Models\Request as Transaction;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Http\Resources\UserResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TransactionResource;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $currentRole = (\Auth::check()) ? \Auth::user()->role : null;
        $laboratory = []; $inventory = [];

        $lists = ListMenu::where('is_mother',1)->where('module','Executive')->orderBy('order','ASC')->get();
        foreach($lists as $list){
            $submenus = [];
            if($list['has_child']){
                $subs = ListMenu::where('is_active',1)->where('group',$list['name'])->get();
                foreach($subs as $menu){
                    $submenus[] = $menu;
                }
            }
            $executive[] = [
                'main' => $list,
                'submenus' => $submenus
            ];
        }

        $lists = ListMenu::where('is_mother',1)->where('module','Main')->orderBy('order','ASC')->get();
        foreach($lists as $list){
            $submenus = [];
            if($list['has_child']){
                $subs = ListMenu::where('is_active',1)->where('group',$list['name'])->get();
                foreach($subs as $menu){
                    $submenus[] = $menu;
                }
            }
            $main[] = [
                'main' => $list,
                'submenus' => $submenus
            ];
        }

        $student_count = Student::where('status_id',15)->count();
        $document_count = Transaction::whereIn('status_id',[5,6,7])->count();
        $s = ($student_count == 0) ? '' : '('.$student_count.')';
        $r = ($document_count == 0) ? '' : '('.$document_count.')';
        $documents = '';
        return [
            ...parent::share($request),
            'user' => (\Auth::check()) ? new UserResource(User::with('profile')->where('id',\Auth::user()->id)->first()) : '',
            'flash' => [
                'data' => session('data'),
                'message' => session('message'),
                'info' => session('info'),
                'status' => session('status'),
                'type' => session('type')
            ],
            'menus' => [
                'executive' => $executive,
                'main' => $main
            ],
            'notification' => [
                'student' => $student_count,
                'document' => $document_count,
                'total' => $student_count + $document_count,
                's' => 'Student '.$s,
                'r' => 'Request '.$r,
                'document_lists' => $this->lists(),
                'student_lists' => $this->students()
            ]
        ];
    }

    private function lists(){
        $data = TransactionResource::collection(
            Transaction::query()
            ->with('user.student','type','payment.status','status','comments.user.profile','authorization')
            ->with('log.prepared.profile','log.processed.profile','log.completed.profile','log.released.profile')
            ->with('lists.status','lists.document.name','lists.document.type','lists.user.profile')
            ->whereIn('status_id',[5,16,6,7])
            ->orderBy('created_at','DESC')
            ->paginate(5)
        );
        return $data;
    }

    private function students(){
        $data = StudentResource::collection(
            Student::query()
            ->with('status','attachments')
            ->where('status_id',15)
            ->orderBy('created_at','DESC')
            ->get()
        );
        return $data;
    }
}
