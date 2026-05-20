<?php

namespace App\Http\Controllers;

use App\Head;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FourthHeadController extends Controller
{
    public function index(Request $req)
    {

        $user_id = Auth::user()->id;
        // $sql ="SELECT  first_head .`user_id` as `user_id`,third.`id` AS id,first_head.`head_name` AS first_name, second_head.`head_name` AS second_name,third.`head_name` AS third_name
        //         FROM `heads` AS first_head
        //         INNER JOIN `heads` AS second_head
        //             ON  second_head.`parent_id`  = first_head.`id`
        //         INNER JOIN `heads` AS third
        //             ON third.`child_id`=second_head.id  where first_head .`user_id`=$user_id";
        // if(isset($req->search)){
        //         $sql .=" and third.`head_name`  LIKE  '$req->search%'";
        // }

        // $data =['headss'=>\DB::select($sql)];

        $data = DB::table('heads AS first_head')
            ->select(
            'first_head.user_id AS user_id', //User Id 
            'fourth_head.id AS id',  // Id
            'first_head.head_name AS first_name', //Name 
            'second_head.head_name AS second_name', // Second Head Name
            'third.head_name AS third_name', // Third Name
            'fourth_head.head_name AS forth_name' // Forth Name
            )
            ->join('heads AS second_head', 'second_head.parent_id', '=', 'first_head.id')
            ->join('heads AS third', 'third.child_id', '=', 'second_head.id')
            ->join('heads AS fourth_head', 'fourth_head.forth_head', '=', 'third.id') 

            ->where('first_head.user_id', $user_id)
            ->get();
            // dd($data);

        return view('child_fourhead.index')->with('headss',$data);
    }
    public function add()
    {
        $data = array(
            'heads' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('slug', '!=', 'banana_agreement')->where('user_id', Auth::user()->id)->get(),
        );
        return view('child_fourhead.add_child_fourhead')->with($data);
    }
    public function store(Request $req)
    {
        //check child subhead name exists or not
        if (!empty($req->id)) {
            if (Head::where('parent_id', 0)->where('child_id', $req->subhead_id)->where('forth_head', $req->chil_id)->where('head_name', $req->forth_subhead)->where('id', '!=', $req->id)->exists()) {
                return response()->json([
                    'error' => 'Third Head already exists',
                ]);
            }
        } elseif (Head::where('parent_id', 0)->where('child_id', $req->subhead_id)->where('head_name', $req->child_subhead)->exists()) {
            return response()->json([
                'error' => 'Third Head already exists',
            ]);
        }

        if (!empty($req->id)) {
            $child_subhead = Head::find($req->id);
        } else {
            $child_subhead = new Head;
        }
        $child_subhead->user_id = Auth::user()->id;
        $child_subhead->parent_id = 0;
        $child_subhead->head_name = $req->forth_subhead;
        $child_subhead->child_id = 0;
        $child_subhead->forth_head = $req->chil_id;
        $child_subhead->slug = str_replace(' ', '_', $req->forth_subhead);
        $child_subhead->save();

        return response()->json([
            'success' => 'Forth Head  Added Successfully',
            'reload' => TRUE,
        ]);
    }
    public function edit($id)
    {
        if (!empty($id)) {
            
            if (Head::where('id', $id)->exists()) {
                // dd($id);
                $data = array(
                    'heads' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('slug', '!=', 'banana_agreement')->where('user_id', Auth::user()->id)->get(),
                    'update_child' => Head::where('id', $id)->first(),
                    'id' => $id,
                    'update' => TRUE,
                );
                // dd($data['heads']);
                $a = Head::where('id', $data['update_child']->forth_head)->first();
                $b = Head::where('id', $a->child_id)->first();
                
                $d = Head::where('child_id', $b->id)->first();
                // $c = Head::where('id', $a->chil_id)->first();
                // dd($b);
                $data['head_id'] = $b;
                $data['second_id'] =  $d;
                $data['subheads'] = Head::where('id', $a->child_id)->get();
                $data['third_heads'] = Head::where('child_id', $d->child_id)->get();
                // dd($d);

                return view('child_fourhead.add_child_fourhead')->with($data);
            }
        }
    }
    public function delete($id){
        if((Auth::check() && Auth::user()->type == 'company')||(Auth::user()->can('delete fourth subhead')) ){
            $head = Head::find($id);
            $head->delete();
            return response()->json([
                'success' => 'Forth Head  Deleted Successfully',
                'reload' => TRUE,
            ]);
        }else{
            return redirect()->back()->with('error','Permission Denied');
        }
    }
}