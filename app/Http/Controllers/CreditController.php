<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Head;
use App\Expense;
class CreditController extends Controller
{
    public function index(){
        return view('credit.index');
    }

    public function add(){
        
        
        if($_GET['add']){
            $data = array(
                'heads'  =>Head::where('parent_id','=',0)->get(),
                'subheads' => Head::where('parent_id','!=',0)->get(),    
            );
        }
        
        return view('credit.credit_form')->with($data);
    }

    public function store(Request $req){
        //if request id is set and not empty it means its about to update
        if(isset($req->expense_id) && !empty($req->expense_id)){
            $data = array();
            foreach($req->expense_id AS $key=>$id){
               
                $update_expense = Expense::find($id);
               
                $update_expense->head_id      = $req->head[$key];
                $update_expense->subhead_id   = $req->subhead[$key];
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
            return redirect()->route('credits.show')->with('success','Credit Expense has been updated successfully');

        }else{//insert new records
            $expense = new Expense;
        }
        $data = array();
        $date = date('Y-m-d H:i:s');
        foreach($req->head AS $key=>$head){
            $data[] = [
                'head_id'        =>  $req->head[$key],
                'subhead_id'     =>  $req->subhead[$key],
                'user_id'        =>  $req->user_id,
                'work'           =>  $req->work[$key],
                'acres'          =>  $req->acres[$key],
                'material'       =>  $req->material[$key],
                'quantity'       =>  $req->quantity[$key],
                'unit_rate'      =>  $req->unit_rate[$key],
                'total'          =>  $req->total[$key],
                'payment_type'   =>  $req->payment_type,
                'note'           =>  $req->note[$key],
                'expense_date'   =>  $req->expense_date,
                'created_at'     =>  $date,
            ];
            
        }
        
    
        Expense::insert($data);

        return redirect()->route('credits.show')->with('success','Credit Expense has been added successfully');

    }

    public function edit(){
        
        if($_GET['edit'] && $_GET['date']){

            $data = array(
                
                'heads'  =>Head::where('parent_id','=',0)->get(),
                'subheads' => Head::where('parent_id','!=',0)->get(), 
                'expense_data'  => Expense::where('expense_date',$_GET['date'])->where('payment_type','1')->get(),
                'edit'  => TRUE,
            );
            
            return view('credit.credit_form')->with($data);

        }else{
            return redirect()->back()->with('error','Please select the recrod');
        }
    }

    public function delete($id){
        
        if($expense = Expense::find($id)){
            $expense->delete();
            return redirect()->back()->with('success','Data has been deleted successfully');

        }
        return redirect()->back()->with('Error','Record could not be found');
    }

    public function subhead($id){
        $html = '';
        if(Head::find($id)){
            $subheads = Head::where('parent_id',$id)->get();
           
            if(count($subheads)>0){
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
}
