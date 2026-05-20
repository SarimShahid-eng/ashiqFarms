<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\BankBranch;
use App\Customer;
use App\Balance;
use App\CustomerAccountReportSetting;
use App\Transaction;
use App\CustomerBankBranch;
use App\EntryReason;
use Auth;

class CustomerAccountController extends Controller
{
    public function index(){
        $data = array(
            'balances' => Balance::with(['parentBank','parentBankBranch','parentCustomer','parentTransaction'])->orderByDesc('id')->paginate(50),
        );
        return view('accounts.customer_accounts.index')->with($data);
    }
    //add customers accounts payments
    public function add(){
        $data = array(
            'reasons'   => EntryReason::get(),
            'transactions'  => Transaction::get(),
            'customers' => Customer::get(),
        );
        return view('accounts.customer_accounts.user_payments')->with($data);
    }
    

    //shows the banks of customers
    public function customerBank($id){
        $html = '<option value="" selected disabled>Select Bank</option>';
        
        $banks_arr = array();

        if(!empty($id)){
            if(Customer::where('id',$id)->exists()){
                if(CustomerBankBranch::where('customer_id',$id)->exists()){
                    $customer_bank_branch = CustomerBankBranch::with(['parentBank'])->where('customer_id',$id)->get();

                    foreach($customer_bank_branch AS $data){
                        
                        if(!in_array($data->bank_id,$banks_arr)){
                            $banks_arr[] = $data->bank_id;
                            $html .= '<option value="'.$data->bank_id.'">'.$data->parentBank->bank_name.'</option>';
                        }
                    }
                    return $html;
                }
            }
        }
        $html = '<option value="" selected disabled>No Banks</option>';
        return $html;
    }

    public function customerBranch($bank_id,$customer_id){
        $html = '';
        if(!empty($bank_id) && !empty($customer_id)){
             if(CustomerBankBranch::where('bank_id',$bank_id)->where('customer_id',$customer_id)->exists()){
                 $customer_branch = CustomerBankBranch::with(['parentBankBranch'])->where('customer_id',$customer_id)->where('bank_id',$bank_id)->get();
                 
                 foreach($customer_branch AS $data){
                     $html .= '<option value="'.$data->branch_id.'">'.$data->parentBankBranch->branch_name.'</option>';
                 }
                 return $html;
             }
        }
        $html = '<option>No Branch</option>';
        return $html;
    }

    public function addRow(Request $req){
        
        $data = array(
            'transactions' => Transaction::get(),
        );
        
        if($req->bank_id != NULL && $req->branch_id != NULL){
            if(Customer::where('bank_id',$req->bank_id)->where('bank_branch_id',$req->branch_id)->exists()){
                $data['customers'] = Customer::where('bank_id',$req->bank_id)->where('bank_branch_id',$req->branch_id)->get();
            }
        }
        
        return view('accounts.customer_accounts.row')->with($data);
    }
    //store and update the customers payments
    public function store(Request $req){
    
            if(isset($req->balance_id) && $req->balance_id !== NULL){
                
                if(Balance::where('id',$req->balance_id)->exists()){
                    $balance = Balance::find($req->balance_id);
                    $msg = 'User updated successfully';
                }
            }else{
            
                $balance = new Balance;
                $msg = 'User balance addedd successfully';
            }
            
            $balance->bank_id = $req->bank_id;
            $balance->bank_branch_id = $req->branch_id;
            $balance->customer_id = $req->customer_id;
            $balance->transaction_id = $req->mode;
            $balance->reason_id = (isset($req->reason_id) ? $req->reason_id : 0);
            $balance->amount = $req->amount;
            $balance->type = $req->type;
            $balance->note = @$req->note;
            $balance->balance_date = $req->date;
            $balance->save();
                
            return response()->json([
                'success'   => $msg,
                'reload'    => TRUE,

            ]);
            
            

    }
    //edit the customer payment
    public function edit($id){
        if($id != NULL){
            if(Balance::where('id',$id)->exists()){
                $data = array(
                    'balance'  => Balance::with(['parentCustomer'])->where('id',$id)->first(),
                    'banks' => Bank::get(),
                    'transactions'  => Transaction::get(),
                    'customers' => Customer::get(),
                    'is_update' => TRUE,
                );
                $data['branches'] = BankBranch::where('bank_id',$data['balance']->bank_id)->get();            
                return view('accounts.customer_accounts.user_payments')->with($data);
                
            }
        }
    }
    //delete the customer payment
    public function delete($id){
        
        if(isset($id) && $id !== NULL){
            if(Balance::where('id',$id)->exists()){
                if(Balance::where('id',$id)->delete()){
                    return response([
                        'success'   => 'User balance deleted succesfully',
                        'redirect'  => route('accounts.customer_accounts.show')
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    //methods for customer_account_report_settings 

    public function userAccountReportIndex(Request $req){
        $user_id = Auth::User()->id;
        $setting = CustomerAccountReportSetting::where('user_id',$user_id)->first();
        $data = array(
            'banks' => Bank::get(),
            'branches'  => BankBranch::get(),
            'bank_ids'   => ($setting) ? json_decode($setting->data)->banks : [],
            'bank_branch_ids' => ($setting) ? json_decode($setting->data)->branches : [],
            'customers'  => Customer::get(), 
            'user_report_id'   => (isset($setting->user_id)) ? $setting->user_id : '',
            'user_id'   => $user_id,
        );
        
        return view('accounts.customers_accounts_report.customers_accounts_report')->with($data);
    }


    public function search(Request $req){
        $balance  = Balance::with(['parentBank','parentBankBranch','parentCustomer']);
        $report = "All In/Out Payments Report";
        
        if(isset($req->banks) && $req->banks != NULL){
            $balance = $balance->where('bank_id',$req->banks);
        }
        if(isset($req->branches) && $req->branches != NULL){
            $balance = $balance->whereIn('bank_branch_id',$req->branches);
        }
        if(isset($req->customer) && $req->customer != NULL){
            $balance = $balance->where('customer_id',$req->customer);
        }else{
            $balance = $balance->where('customer_id',Auth::user()->id);
        }
        // if(Auth::user()->type != 'comapny'){
        //     $balance = $balance->where('customer_id',Auth::user()->id);
        // }
        if(isset($req->type) && $req->type != NULL){
            if($req->type == 'in'){
                $type = 'in';
                $report = "In payments Report";
                $balance = $balance->where('type',$type);
            }elseif($req->type == 'out'){
                $type = 'out';
                $report = "Out Payments Report";
                $balance = $balance->where('type',$type);
            }elseif($req->type == 'all'){
                $type = 'all';
                $report = "All In/Out Payments Report";
            }
        }else{
            $type = 'all';
        }
        //check it edit is set or not
        if(isset($req->edit) && $req->edit != NULL){
            $edit = TRUE;
        }
        
        $balance = $balance->whereDate('balance_date','>=',$req->from_date)
                    ->whereDate('balance_date','<=',$req->to_date)
                    ->get();
        //get the opening balanace of branch
        if(isset($req->branches)){
            if(count($req->branches) == 1){
                $opening_balance = BankBranch::where('bank_id',$req->banks)->where('id',$req->branches)->first();

            }
        }
    

        if($balance->isNotEmpty()){
            $data = array(
                'from_date' => $req->from_date,
                'to_date'   => $req->to_date,
                'balance'   => $balance,
                'report'    => $report,
                'type'      => $type,
                'edit'      => (isset($edit))?TRUE:NULL,
                'opening_balance'    => @$opening_balance,
            );
            
            return view('accounts.customers_accounts_report.report')->with($data);
        }else{
            return redirect()->back()->with('error','No Record Found');
           
        }                                        
    }

    public function columnColor($id){
        if(!empty($id) && isset($_GET['colorCode'])){
            $color = Balance::find($id);
            $color->column_color = $_GET['colorCode'];
            $color->save();
        }
    }

    public function editReport($id){
        $data = array(
            'balance'  => Balance::where('id',$id)->first(),
            'customers' => Customer::get(),
            'transactions'  => Transaction::get(),
            'reasons'       => EntryReason::get(),
        );
        $data['branches'] = BankBranch::where('bank_id',$data['balance']->bank_id)->get();
        $data['customerBanksBranches'] = CustomerBankBranch::with(['parentBank','parentBankBranch'])->where('customer_id',$data['balance']->customer_id)->get();
        return view('accounts.customers_accounts_report.edit_row')->with($data);
    }

    public function updateReport(Request $req){
        // dd($req->all());
        if(isset($req->id) && $req->id != NULL){
            if(Balance::where('id',$req->id)->exists()){
                $update = Balance::where('id',$req->id)->first();
                $update->bank_id = $req->bank_id;
                $update->bank_branch_id = $req->branch_id;
                $update->customer_id = $req->customer_id;
                $update->reason_id = (isset($req->reason_id) ? $req->reason_id : 0);
                $update->transaction_id = $req->mode;
                $update->amount = $req->amount;
                $update->type = $req->type;
                $update->note = $req->note;
                $update->balance_date = $req->created_at;
                $update->save();

                $updated_row = Balance::with(['parentBank','parentBankBranch','parentCustomer','parentTransaction','parentReason'])->where('id',$req->id)->first();
                return view('accounts.customers_accounts_report.updated_row')->with(['row'=>$updated_row]);

            }
        }
        return redirect()->route('accounts.customer_accounts.report');
    }

    public function deleteReport($id){
        
        if(isset($id) && $id != NULL){
            if(Balance::where('id',$id)->exists()){
                Balance::where('id',$id)->delete();
            }
        }
    }


    public function UserBankAndBranch($id){
        
        if(isset($id) && $id != NULL){
            if(Customer::where('id',$id)->exists()){
                $data = array(
                    'banks' => Customer::with('parentBank')->where('id',$id)->first(),
                );
            }
            dd($data);
        }
        
    }
    
}
