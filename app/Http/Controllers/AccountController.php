<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bank;
use App\BankBranch;

class AccountController extends Controller
{
    public function bank(Request $req){
            
        $data = array(
            'data'  => Bank::orderBy('id','DESC')->paginate(50),
        );
        if(isset($req->id)){
            if(Bank::where('id',$req->id)->exists()){
                $data['is_update'] = TRUE;
                $data['update'] = Bank::where('id',$req->id)->first();
            }
        }
        return view('accounts.bank')->with($data);
    }

    public function store(Request $req){
        // dd($req->all());
        if(!empty($req->bank_id)){
            if(Bank::where('id',$req->bank_id)->exists()){
                if(Bank::where('bank_name',$req->bank_name)->where('id','!=',$req->bank_id)->doesntExist()){
                    $update = Bank::find($req->bank_id);
                    $update->bank_name = $req->bank_name;
                    $update->save();

                    return response()->json([
                        'success'   => 'Bank updated successfully',
                        'redirect' => route('accounts.banks.show'),
                    ]);
                }
            }
        }else{
            if(Bank::where('bank_name',$req->bank_name)->doesntExist()){
                $bank = new Bank;
                $bank->bank_name = $req->bank_name;
                $bank->save();

                return response([
                    'success'   => 'Bank added successfully',
                    'redirect' => route('accounts.banks.show'),
                ]);
            }
        }

        return response()->json([
            'error' => 'Bank name already exists',
        ]);

    }

    public function delete($id){
        if(Bank::where('id',base64_decode($id))->exists()){
            $head = Bank::find(base64_decode($id));
            $head->delete();
            return response()->json([
                'success'   => 'Bank Deleted Successfully',
                'reload'    => TRUE,
            ]);
        }else{
            return response()->json([
                'error' => 'Unknown bank id',
                'redirect' => route('accounts.banks.show')
            ]);
        }
    }
    //functions for bank branch

    public function bankBranchList(){
        $data = array(
            'branches'  => BankBranch::with(['parentBank','childBalance','childBalanceTypeIn','childBalanceTypeOut'])->get(),
        );

        return view('accounts.bank_branch_list')->with($data);
    }

    public function bankBranchAdd(){
        $data = array(
            'banks' => Bank::get(),
        );
        return view('accounts.bank_branch')->with($data);
    }
    //this funtion store and update the data
    public function bankBranchStore(Request $req){

        if(isset($req->update_id) && $req->update_id !== NULL){
            $bank_branch = Bankbranch::find($req->update_id);
            $msg = 'Bank Branch Updated successfully';

        }else{
            $bank_branch = new BankBranch;
            $msg = 'Bank Branch Added Successfully';
        }

        $bank_branch->bank_id         = $req->bank_id;
        $bank_branch->branch_name     = $req->branch_name;
        $bank_branch->branch_code     = $req->branch_code;
        $bank_branch->opening_balance = $req->opening_balance;
        $bank_branch->location               = $req->location;
        $bank_branch->save();

        return response()->json([
            'success'   => $msg,
            'redirect'  => route('accounts.branches.show'),
        ]);
    }

    //edit bank_branch
    public function bankBranchEdit($id){
        if(BankBranch::where('id',$id)->exists()){
            $data = array(
                'banks' => Bank::get(),
                'edit' => BankBranch::find($id),
                'is_update' => TRUE,
            );

            return view('accounts.bank_branch')->with($data);
        }
        return response()->json([
           'error'  => 'Wrong id passed',
           'reload' => TRUE, 
        ]);
    }

    //delete bank branch
    public function bankBranchDelete($id){
        if(BankBranch::where('id',$id)->exists()){
            BankBranch::find($id)->delete();
            return response()->json([
                'success'   => 'Bank Branch Deleted Successfully',
                'reload'    => TRUE,
            ]);
        }
        return redirect()->back();
    }
}
