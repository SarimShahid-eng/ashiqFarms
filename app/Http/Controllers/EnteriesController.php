<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\User;
use App\Head;
use Auth;
class EnteriesController extends Controller
{
    public function index(){
        $expense = Expense::with(['parentHead','parentSubhead','parentChildSubhead','parentForthSubhead','parentUser']);
        $current_15_days = date('Y-m-15');
        $past_15_days = date('Y-m-15',strtotime('-15 days'));
        
        //if user is not admin then displat thoes enteries which were entered by user admin can see all user enteries
        if(Auth::user()->type != 'company'){
            $expense = $expense->where('user_id',Auth::user()->id);
        }
        // $expense = $expense->whereBetween('expense_date',[$past_15_days,$current_15_days])->get()->sortBy('parentHead.head_name');
        // $expense = $expense->latest()->limit(15)->get()->sortBy('parentHead.head_name');
        $expense = $expense->latest('id')->limit(15)->get();
        $data = array(
            'lists'   => $expense,
            'users'=>User::latest()->get()
        );
        return view('entries.index')->with($data);
    }

    public function add(){

        if($_GET['add']){
            $data = array(
                'heads'  =>Head::where('parent_id','=',0)
                            ->whereNotIn('id', [657, 191])
                            ->where('child_id',0)->where('forth_head',0)
                            ->where('slug','!=','banana_agreement')
                            ->where('user_id',Auth::user()->id)
                            ->orderBy('head_name', 'ASC')
                            ->get(),
            );
        }
        // echo 'hello';
        // exit;
        return view('entries.entry_form')->with($data);
    }

    // public function store(Request $req){
    //     //if request id is set and not empty it means its about to update
    //     if(isset($req->expense_id) && !empty($req->expense_id)){
    //         $data = array();
    //         foreach($req->expense_id AS $key=>$id){

    //             $update_expense = Expense::find($id);

    //             $update_expense->head_id      = $req->head[$key];
    //             $update_expense->subhead_id   = $req->subhead[$key];
    //             $update_expense->child_subhead_id     = @$req->child_subhead[$key];
    //             $update_expense->work         = $req->work[$key];
    //             $update_expense->acres        = $req->acres[$key];
    //             $update_expense->material     = $req->material[$key];
    //             $update_expense->quantity     = $req->quantity[$key];
    //             $update_expense->unit_rate    = $req->unit_rate[$key];
    //             $update_expense->total        = $req->total[$key];
    //             $update_expense->note         = $req->note[$key];
    //             $update_expense->payment_type = $req->payment_type[$key];
    //             $update_expense->expense_date = $req->expense_date[$key];
    //             $update_expense->user_id      = $req->user_id[$key];
    //             $update_expense->save();
    //         }
    //         return response([
    //             'success'  => 'Entry  updated successfully',
    //             'redirect' => route('enteries.show'),
    //         ]);
    //     }else{//insert new records
    //         $expense = new Expense;
    //     }
    //     $data = array();
    //     $date = date('Y-m-d H:i:s');
    //     foreach($req->head AS $key=>$head){
    //         $data[] = [
    //             'head_id'        =>  $req->head[$key],
    //             'subhead_id'     =>  $req->subhead[$key],
    //             'user_id'        =>  $req->user_id,
    //             'work'           =>  $req->work[$key],
    //             'acres'          =>  $req->acres[$key],
    //             'material'       =>  $req->material[$key],
    //             'quantity'       =>  $req->quantity[$key],
    //             'unit_rate'      =>  $req->unit_rate[$key],
    //             'total'          =>  $req->total[$key],
    //             'payment_type'   =>  $req->payment_type[0],
    //             'note'           =>  $req->note[$key],
    //             'expense_date'   =>  $req->expense_date,
    //             'created_at'     =>  $date,
    //             'child_subhead_id'  => $req->child_subhead[$key],
    //         ];

    //     }


    //     Expense::insert($data);

    //     return response([
    //         'success' => "Entry added successfully",
    //         'redirect'  => route('enteries.show'),
    //     ]);
    // }
        public function store(Request $req){
            // dd($req->currentuser_id);
        //if request id is set and not empty it means its about to update
        if(isset($req->expense_id) && !empty($req->expense_id)){
            $data = array();
            foreach($req->expense_id AS $key=>$id){

                $update_expense = Expense::find($id);

                $update_expense->head_id      = $req->head[$key];
                $update_expense->subhead_id   = $req->subhead[$key];
                $update_expense->child_subhead_id     = @$req->child_subhead[$key];
                $update_expense->forth_head     = @$req->forth_subhead[$key];
                $update_expense->work         = $req->work[$key];
                $update_expense->acres        = $req->acres[$key];
                $update_expense->material     = $req->material[$key];
                $update_expense->quantity     = $req->quantity[$key];
                $update_expense->unit_rate    = $req->unit_rate[$key];
                $update_expense->total        = $req->total[$key];
                $update_expense->note         = $req->note[$key];
                $update_expense->payment_type = $req->payment_type[$key];
                $update_expense->expense_date = $req->expense_date[$key];
                $update_expense->user_id      = $req->user_id[$key];
                $update_expense->save();
            }
            return response([
                'success'  => 'Entry  updated successfully',
                'redirect' => route('enteries.show'),
            ]);
        }else{//insert new records
            $expense = new Expense;
        }
        $data = array();
        $date = date('Y-m-d H:i:s');

        $arr = array();
        $no = 0;
        foreach($req->head AS $key=>$head){
           ++$no;
            $f= Expense::where('head_id',$req->head[$key])->where('subhead_id',$req->subhead[$key])->where('child_subhead_id',$req->child_subhead[$key])->where('forth_head',$req->forth_subhead[$key])->where('work',$req->work[$key])->where('acres',$req->acres[$key])->where('material',$req->material[$key])->where('quantity',$req->quantity[$key])->where('unit_rate',$req->unit_rate[$key])->where('total',$req->total[$key])->where('payment_type',$req->payment_type[0])->where('note',$req->note[$key])->where('expense_date',$req->expense_date)->first();
           
            if($f==null){

                $data[] = [
                    'head_id'        =>  $req->head[$key],
                    'subhead_id'     =>  $req->subhead[$key],
                    'forth_head'     =>  $req->forth_subhead[$key],
                    'user_id'        =>  $req->user_id,
                    'work'           =>  $req->work[$key],
                    'acres'          =>  $req->acres[$key],
                    'material'       =>  $req->material[$key],
                    'quantity'       =>  $req->quantity[$key],
                    'unit_rate'      =>  $req->unit_rate[$key],
                    'total'          =>  $req->total[$key],
                    'payment_type'   =>  $req->payment_type[0],
                    'note'           =>  $req->note[$key],
                    'expense_date'   =>  $req->expense_date,
                    'created_at'     =>  $date,
                    'child_subhead_id'  => $req->child_subhead[$key],
                ];
                if($req->currentuser_id !== null){
                $data[] = [
                    'head_id'        =>  $req->head[$key],
                    'subhead_id'     =>  $req->subhead[$key],
                    'forth_head'     =>  $req->forth_subhead[$key],
                    'user_id'        =>  $req->currentuser_id,
                    'work'           =>  $req->work[$key],
                    'acres'          =>  $req->acres[$key],
                    'material'       =>  $req->material[$key],
                    'quantity'       =>  $req->quantity[$key],
                    'unit_rate'      =>  $req->unit_rate[$key],
                    'total'          =>  $req->total[$key],
                    'payment_type'   =>  $req->payment_type[0],
                    'note'           =>  $req->note[$key],
                    'expense_date'   =>  $req->expense_date,
                    'created_at'     =>  $date,
                    'child_subhead_id'  => $req->child_subhead[$key],
                ];
}
            }else{
                $arr[] = $key+1;
            }


        }
        
        if(count($arr) > 0){
               return response()->json([
                    'error' => "Dublicate Entry(Entry no ".implode(",",$arr).")",
                ]);
        }
        // dd($data);

        Expense::insert($data);

        return response([
            'success' => "Entry added successfully",
            'redirect'  => route('enteries.show'),
        ]);
    }

    public function edit(){
    
        if(isset($_GET['edit']) && isset($_GET['date']) && isset($_GET['type'])){
            

            $e =Expense::where('expense_date',$_GET['date'])->where('payment_type',$_GET['type'])->where('schedule_id',NULL)->get();
            $e = $e->pluck('head_id')->all();
            $heads = Head::whereIn('id',$e)->where('user_id',Auth::user()->id)->get();
        
            $sub_head = Head::whereIn('parent_id',$e)->where('user_id',Auth::user()->id)->get();
            $c = $sub_head->pluck('id')->all();
            $child_head = Head::whereIn('child_id',$c)->where('user_id',Auth::user()->id)->get();
            $d = $child_head->pluck('id')->all();
            $fourth_head = Head::whereIn('forth_head',$d)->where('user_id',Auth::user()->id)->get();
            
            $data = array(
                'heads'  =>Head::with(['sub'])->where('parent_id','=',0)->where('slug','!=','banana_agreement')->where('user_id',Auth::user()->id)->get(),
                'expense_data'  => Expense::where('expense_date',$_GET['date'])->where('payment_type',$_GET['type'])->where('schedule_id',NULL)->get(),
                'head'  => $heads,
                'sub_head'  => $sub_head,
                'child_head'    => $child_head,
                'forth_head'    => $fourth_head,
                'edit'  => TRUE,
            );

            return view('entries.entry_form')->with($data);
        }else{
            return response([
                'error' => 'error',
                'reload' => false,
            ]);
        }
    }

    public function delete($id){

        if($expense = Expense::find($id)){
            $expense->delete();
            return redirect()->back()->with('success','Data has been deletedd successfully');

        }
        return redirect()->back()->with('Error','Record could not be found');
    }

    public function subhead(Request $req){
        $html = '';
        $id = $req->id;
        if(Head::find($id)){
            $subheads = Head::where('parent_id',$id)->orderBy('head_name', 'ASC')->get();

            if(count($subheads)>0){
                $html .= '<option value="" selected>Select Subhead</option>';
                foreach($subheads AS $subhead){
                    $html .= '<option value="'.$subhead->id.'">'.$subhead->head_name.'</option>';
                }
                return $html;
            }else{
                $html .= "<option value=''>No Subheads</option>";
                return $html;
            }

        }
    }

    public function childSubhead(Request $req){
        
        $html = '';
        $id = $req->id;
        if(Head::find($id)){
           
            if(is_array($req->id)){
            $child = Head::whereIn('child_id',$id)->orderBy('head_name', 'ASC')->get();
           }else{
            $child = Head::where('child_id',$id)->orderBy('head_name', 'ASC')->get();
           }

            if(count($child)>0){
                   $html.='<option>Select Third Head</option>';
                foreach($child AS $subhead){
                    $html .= '<option value="'.$subhead->id.'">'.$subhead->head_name.'</option>';
                }
                return $html;
            }else{
                $html .= "<option value=''>No Subheads</option>";
                return $html;
            }

        }

    }
    public function forthSubhead(Request $req){
        
        $html = '';
        $id = $req->id;
        if(Head::find($id)){
           
            if(is_array($req->id)){
            $child = Head::whereIn('forth_head',$id)->orderBy('head_name', 'ASC')->get();
           }else{
            $child = Head::where('forth_head',$id)->orderBy('head_name', 'ASC')->get();
           }

            if(count($child)>0){
                $html.='<option>Select Forth Head</option>';
                foreach($child AS $subhead){
                    $html .= '<option value="'.$subhead->id.'">'.$subhead->head_name.'</option>';
                }
                return $html;
            }else{
                $html .= "<option value=''>No Forth heads</option>";
                return $html;
            }

        }

    }

    public function search($type,$from,$to){
            $html = '';

            if($type == 1){
                $t = "Expense";
            }elseif($type == 2){
                $t = "Paid";
            }else{
                $t = "Income";
            }


            $lists = Expense::with(['parentHead','parentSubhead','parentChildSubhead','parentUser'])
                        ->where('payment_type',$type)
                        ->whereDate('expense_date','>=',$from)
                        ->whereDate('expense_date','<=',$to);
            
            if(Auth::user()->type != 'company'){
                $lists = $lists->where('user_id',Auth::user()->id);
            }

            $lists = $lists->get();

            if(count($lists)>0){
                foreach($lists AS $list){
                    $html .= '<tr style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$t .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. get_date($list->expense_date) .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->parentHead->head_name .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->parentSubhead->head_name .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->parentChildSubhead->head_name .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->work .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->acres .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->material .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->quantity .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. @$list->unit_rate .'</td style="border: 1px solid #000">
                                <td style="border: 1px solid #000">'. round($list->total) .'</td>
                                <td style="border: 1px solid #000">'. @$list->parentUser->name .'</td>
                            </tr>';
                }
                return $html;
            }else{
                $html .= '<tr><td colspan="9">No Record Found<td></tr>';
                return $html;
            }
        
    }
}
