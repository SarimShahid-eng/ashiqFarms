<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Head;
use DB;
class SubHeadController extends Controller
{
    public function index(Request $req){
            $data = array(
                'data'  => Head::with(['parent'])
                                ->where('parent_id','!=',0)
                                ->where('child_id',0)
                                
                                ->where('slug','!=','banana')->where('user_id',Auth::user()->id)
                                ->when(isset($req->search), function($query) use ($req){
                                    $query->where('head_name', 'LIKE', $req->search.'%');
                                })->get(),
            );

            return view('subhead.index')->with($data);

    }

    public function add(){
        $data = array(
            'data' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('slug', '!=', 'banana_agreement')->where('user_id', Auth::user()->id)->get(),
        );
        return view('subhead.add')->with($data);
    }

    public function store(Request $req){
            if(!empty($req->id)){
                if(Head::where('parent_id',$req->parent_id)->where('head_name',$req->subhead)->where('id','!=',$req->id)->exists()){
                    return response()->json([
                        'error' => 'Subhead already exists',
                    ]);
                }
            }elseif(Head::where('parent_id',$req->parent_id)->where('head_name',$req->subhead)->exists()){
                return response()->json([
                    'error' => 'Subehad already exists',
                ]);
            }
            if(isset($req->id) && !empty($req->id)){
                    $subhead = Head::find($req->id);
                    $update = TRUE;
                    $subhead->user_id =  Auth::user()->id;
                    $subhead->parent_id = $req->parent_id;
                    $subhead->head_name = $req->subhead;
                    $subhead->save();
            }else{
                $subhead = new Head;
                $subhead->user_id =  Auth::user()->id;
                $subhead->parent_id = $req->parent_id;
                $subhead->head_name = $req->subhead;
                $subhead->slug = str_replace(' ','_',$req->subhead);
                $subhead->save();
            }
            return response()->json([
                'success'   => 'SubHead Head  Added Successfully',
                'reload'    => TRUE,
            ]);
            
    }

    public function edit($id){

        // if(Auth::check() && Auth::user()->type == 'company'){
        if(Auth::check()){
            $data = array(
                'update_subhead' =>Head::find($id),
                'data' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('slug', '!=', 'banana_agreement')->where('user_id', Auth::user()->id)->get(),
                'update' => TRUE,
                'id'   => $id,
            );
            return view('subhead.add')->with($data);
        }else{
            return redirect()->back()->with('error','Permission denied');
        }

    }

    public function delete($id){
         $second_head = Head::find($id);
            $third_head = Head::where('child_id',$id)->get();
            if($third_head != null){
                foreach($third_head as $forth){
                    Head::where('forth_head',$forth->id)->delete();    
                }
                 Head::where('child_id',$id)->delete();
            }
            $second_head->delete();
            
         return response()->json([
                'success'   => 'Sub Head Deleted',
                 'redirect'  => route('expense.subheads.show'),
            ]);
    }
}
