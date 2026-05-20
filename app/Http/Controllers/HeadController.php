<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Head;
class HeadController extends Controller
{
    public function index(Request $req){
        $data = array(
            'data'  => Head::where('parent_id',0)->where('child_id',0)->where('forth_head',0)->where('slug','!=','banana_agreement')->where('user_id',Auth::user()->id)->when(isset($req->search), function($query) use ($req){
                $query->where('head_name', 'LIKE', $req->search.'%');
            })->orderBy('head_name', 'ASC')->get(),
        );

        if(isset($req['id'])){
            $data['is_update'] = TRUE;
            $data['update_head'] = Head::where('id',$req->id)->first();
        }

        return view('head.index')->with($data);
    }

    public function store(Request $req){

        if(!empty($req->head_id)){
            if(Head::where('id',$req->head_id)->exists()){
                if(Head::where('head_name',$req->head)->where('id','!=',$req->head_id)->where('parent_id',0)->doesntExist()){
                    $update = Head::find($req->head_id);
                    $update->user_id = Auth::user()->id;
                    $update->head_name = $req->head;
                    $update->save();

                    return response()->json([
                        'success' => 'Head has been updated successfully',
                        'redirect'  => route('expense.heads.show'),
                    ]);
                }
            }
        }else{
            if(Head::where('head_name',$req->head)->where('parent_id',0)->doesntExist()){
                $head = new Head;
                $head->user_id = Auth::user()->id;
                $head->head_name = $req->head;
                $head->slug = str_replace(' ', '_', $req->head);
                $head->parent_id = 0;
                $head->save();

                return response()->json([
                    'success'   => 'Head has been added successfully',
                    'redirect'  => route('expense.heads.show'),
                ]);
            }
        }

        return response()->json([
            'error' => 'Head name already exsits',
        ]);

    }

    public function delete($id){

        if((Auth::check() && Auth::user()->type == 'company')|| (Auth::user()->can('delete head'))){
            $head = Head::find($id);
            $second_h = Head::where('parent_id',$id)->get();
            if($second_h != null){
                foreach($second_h as $s){
                    $third_h = Head::where('child_id',$s->id)->get();
                    if($third_h != null)
                    {
                        foreach($third_h as $third){
                            Head::where('forth_head',$third->id)->delete();
                        }
                    }
                    if($third_h != null){
                        Head::where('child_id',$s->id)->delete();
                    }
                }
                $second = Head::where('parent_id',$id)->delete();
            }
            $head->delete();
            return redirect()->route('expense.heads.show')->with('success','Head has been deleted successfully');
        }else{
            return redirect()->back()->with('error','Permission denied.');
        }
    }
}
