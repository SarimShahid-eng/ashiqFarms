<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Head;
use Auth;
class ChildSubheadController extends Controller
{
    public function index(Request $req){
        // dd($req->search);
        // $data = array(
        //     // 'heads'    => Head::with(['inverseChild'])
        //     //                     ->where('child_id','!=',0)
        //     //                     ->where('user_id',Auth::user()->id)
        //     //                     ->when(isset($req->search), function($query) use ($req){
        //     //                         $query->where('head_name', 'LIKE', $req->search.'%');
        //     //                     })->get(),
        //     'headss' => Head::with(['sub'])
        //     ->where('parent_id', 0)
        //     ->where('child_id', 0)
        //     ->where('user_id',Auth::user()->id)
        //     ->when(isset($req->search), function($query) use ($req){
        //         $query->where('head_name', 'LIKE', $req->search.'%');
        //     })
        //     ->orderBy('head_name', 'ASC')
        //     ->get(),


        // );
        $user_id = Auth::user()->id;
        $sql ="SELECT  first_head .`user_id` as `user_id`,third.`id` AS id,first_head.`head_name` AS first_name, second_head.`head_name` AS second_name,third.`head_name` AS third_name
                FROM `heads` AS first_head
                INNER JOIN `heads` AS second_head
                    ON  second_head.`parent_id`  = first_head.`id`
                INNER JOIN `heads` AS third
                    ON third.`child_id`=second_head.id  where first_head .`user_id`=$user_id";
        if(isset($req->search)){
                $sql .=" and third.`head_name`  LIKE  '$req->search%'";
        }
        $sql .= " ORDER BY first_name ASC";

        $data =['headss'=>\DB::select($sql)];


        // dd($data['headss']);
        // $heads = Head::where('parent_id',0)->where('child_id',0)->get()->keyby('id');
        // $data['parent']=$heads;
        // $data['headss'] = Head::with(['sub'])->where('parent_id', 0)->where('child_id', 0)->orderBy('head_name', 'ASC')->get();
        // dd($h->sub[0]->load('child'));
        return view('child_subhead.index')->with($data);
    }

    public function add(){
        $data = array(
            'heads' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('slug', '!=', 'banana_agreement')->where('user_id', Auth::user()->id)->get(),
        );
        return view('child_subhead.add_child_subhead')->with($data);
    }

    public function store(Request $req){
        //check child subhead name exists or not
        if(!empty($req->id)){
            if(Head::where('parent_id',0)->where('child_id',$req->subhead_id)->where('head_name',$req->subhead)->where('id','!=',$req->id)->exists()){
                return response()->json([
                    'error' => 'Third Head already exists',
                ]);
            }
        }elseif(Head::where('parent_id',0)->where('child_id',$req->subhead_id)->where('head_name',$req->child_subhead)->exists()){
            return response()->json([
                'error' => 'Third Head already exists',
            ]);
        }

        if(!empty($req->id)){
            $child_subhead = Head::find($req->id);
        }else{
            $child_subhead = new Head;
        }
        $child_subhead->user_id = Auth::user()->id;
        $child_subhead->parent_id = 0;
        $child_subhead->head_name = $req->child_subhead;
        $child_subhead->child_id = $req->subhead_id;
        $child_subhead->slug = str_replace(' ','_',$req->child_subhead);
        $child_subhead->save();
        if(!empty($req->id)){
                return response()->json([
                    'success'   => 'Second Head  Updated Successfully',
                    'reload'    => TRUE,
                ]);
        }else{
            return response()->json([
                    'success'   => 'Second Head  Added Successfully',
                    'reload'    => TRUE,
                ]);
        }
    }

    public function edit($id){
        if(!empty($id)){
            if(Head::where('id',$id)->exists()){
                $data = array(
                    'heads' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('slug', '!=', 'banana_agreement')->where('user_id', Auth::user()->id)->get(),
                    'update_child'  => Head::where('id',$id)->first(),
                    'id'    => $id,
                    'update'    => TRUE,
                );
                $a = Head::where('id',$data['update_child']->child_id)->first();
                $b = Head::where('id',$a->parent_id)->first();

                $data['head_id'] = $b;
                $data['subheads'] = Head::where('parent_id',$b->id)->get();
                return view('child_subhead.add_child_subhead')->with($data);
            }
        }
    }

    public function delete($id){
        if(!empty($id)){
            if(Head::where('id',$id)->exists()){
                $third_head = Head::find($id);
                $forth = Head::where('forth_head',$id)->first();
                if($forth != null){
                     Head::where('forth_head',$forth->id)->delete();
                }
                $third_head->delete();

                return response()->json([
                    'success'   => 'Second Head Deleted Successfully',
                    'reload'    => TRUE,
                    // 'redirect'  => route('expense.child.subheads.show'),
                ]);
            }
        }
    }
}
