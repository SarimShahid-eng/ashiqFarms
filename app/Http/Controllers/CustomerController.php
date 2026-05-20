<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\BankBranch;
use App\Customer;
use App\CustomerBankBranch;

class CustomerController extends Controller
{
    public function index(){
        $data = array(
            'customers_bank_branch'  => CustomerBankBranch::with(['parentCustomer','parentBank','parentBankBranch'])->paginate(10),
        );
        return view('accounts.customers.index')->with($data);
    }

    public function add(Request $req){
        $data = array(
            'customers' => Customer::get(),
            'banks' => Bank::get(),
        );
        return view('accounts.customers.add_customer')->with($data);
    }

    public function branches(Request $req){
        
        if(isset($req->bank_id) && $req->bank_id !== NULL){
            if(BankBranch::where('bank_id',$req->bank_id)->exists()){
                $html = '';
                $branches = BankBranch::where('bank_id',$req->bank_id)->get();
                
                if($branches->isNotEmpty()){
                    foreach($branches AS $branch){
                        $html .= '<option value="'.$branch->id.'">'.$branch->branch_name.'</option>';
                    }
                    return $html;
                }
                $html = '<option value="">No Branch Exists</option>';
                return $html;
            }
            $html = '<option value="">No Branch Exists</option>';
                return $html;
        }
    }

    public function store(Request $req){
        //upadte user
        if(!empty($req->update_id)){
            if(Customer::where('id',$req->update_id)->exists()){
                if(Customer::where('name',$req->name)->where('id','!=',$req->update_id)->doesntExist()){
                    $customer = Customer::find($req->update_id);
                    $customer->name = $req->name;
                    $customer->save();

                    return response()->json([
                        'success'   => 'User updated successfully',
                        'reload'    => TRUE,
                    ]);
                }
            }
        }else{//for new record
            if(empty($req->update_id)){
                if(Customer::where('name',$req->name)->doesntExist()){
                    $customer = new Customer;
                    $customer->name = $req->name;
                    $customer->save();

                    return response()->json([
                        'success'   => 'User Added Successfully',
                        'reload'    => TRUE,
                    ]);
                }
            }
        }
        return response()->json([
            'error' => 'User Already Exists',
        ]);

    }

    public function edit($id){

        if(!empty($id)){
            if(CustomerBankBranch::where('id',$id)->exists()){
                $data = array(
                    'edit'  => CustomerBankBranch::where('id',$id)->first(),
                    'banks' => Bank::get(),
                    'customers' => Customer::get(),
                    'is_update' => TRUE,
                );
                $data['branches'] = BankBranch::where('bank_id',$data['edit']->bank_id)->get();
                return view('accounts.customers.add_customer')->with($data);
                
            }
        }
    }

    public function delete($id){

        if(!empty($id)){
            if(Customer::where('id',$id)->exists()){
                Customer::where('id',$id)->delete();
                $msg = "User Deleted Successfully";
                if(CustomerBankBranch::where('customer_id',$id)->exists()){
                    CustomerBankBranch::where('customer_id',$id)->delete();
                    $msg = "User And User Banks And Branches Deleted Successfully";
                }
                return response()->json([
                    'success'   => $msg,
                ]);
            }
        }
        return redirect()->back();
        
    }

    //store the customer banks and branches
    public function storeCustomerBankAndBranch(Request $req){

        if(!empty($req->user_id) && !empty($req->bank_id) && !empty($req->bank_branch_id)){
            if(!empty($req->update_id)){
                if(CustomerBankBranch::where('id',$req->update_id)->exists()){
                    if(CustomerBankBranch::where('customer_id',$req->user_id)->where('bank_id',$req->bank_id)->where('branch_id',$req->bank_branch_id)->where('id','!=',$req->update_id)->doesntExist()){
                        
                        $customer_bank_branch = CustomerBankBranch::find($req->update_id);
                        $customer_bank_branch->customer_id = $req->user_id;
                        $customer_bank_branch->bank_id = $req->bank_id;
                        $customer_bank_branch->branch_id = $req->bank_branch_id;
                        $customer_bank_branch->save();

                        return response()->json([
                            'success'   => 'User Band And Branch Updated Successfully',
                            'reload'    => TRUE,
                        ]);
                    }
                }
            }else{
                if(CustomerBankBranch::where('customer_id',$req->user_id)->where('bank_id',$req->bank_id)->where('branch_id',$req->bank_branch_id)->doesntExist()){
        
                    $customer_bank_branch = new CustomerBankBranch;
                    $customer_bank_branch->customer_id = $req->user_id;
                    $customer_bank_branch->bank_id = $req->bank_id;
                    $customer_bank_branch->branch_id = $req->bank_branch_id;
                    $customer_bank_branch->save();

                    return response()->json([
                        'success'   => 'User Band And Branch Added Successfully',
                        'reload'    => TRUE,
                    ]);
                }
            }
            return response()->json([
                'error' => 'User Bank and Branch already exists',
            ]);
        }
        return redirect()->back();
    }

    public function deleteCustomerBankAndBranch($id){
        
        if(!empty($id)){
            if(CustomerBankBranch::where('id',$id)->exists()){
                CustomerBankBranch::where('id',$id)->delete();
                
                return response()->json([
                    'success'   => 'User Bank And Branch Deleted Successflly',
                    'reload'    => TRUE,
                ]);
            }
        }
        return redirect()->back();
    }

    public function customerIndex(Request $req){

        $data = array();
        if(!empty($req->id)){
            if(Customer::where('id',$req->id)->exists()){
                $data['is_update'] = TRUE;
                $data['update'] = Customer::where('id',$req->id)->first();
            }
        }
        $data['customers'] = Customer::with(['childBalanceIn','childBalanceOut'])->paginate(10);
        return view('accounts.customer.index')->with($data);
    }

    public function customerStore(Request $req){
    
       if(!empty($req->customer_id)){
           if(Customer::where('id',$req->customer_id)->exists()){
               if(Customer::where('name',$req->name)->where('id','!=',$req->customer_id)->doesntExist()){
                   $update = Customer::find($req->customer_id);
                   $update->name = $req->name;
                   $update->save();

                return response()->json([
                    'success'   => 'User updated successfully',
                    'redirect'  => route('accounts.customer.show'),
                ]);
              }
            }
        }else{
            if(Customer::where('name',$req->name)->doesntExist()){
                $data = new Customer;
                $data->name = $req->name;
                $data->save();

                return response()->json([
                    'success'   => 'User added successfully',
                    'redirect'  => route('accounts.customer.show'),
                ]);
            }
        }
        return response()->json([
            'error' => 'User name already exists',
        ]);
    }
    
    public function customerDelete($id){
        if(!empty($id)){
            if(Customer::where('id',$id)->exists()){
                Customer::where('id',$id)->delete();

                return response()->json([
                    'success'   => 'User deleted succesfully',
                    'reload'    => TRUE,
                ]);
            }
        }
    }
}

