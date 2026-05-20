<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

class TransactionController extends Controller
{
    public function index($id=NULL){
        
        if(!empty($id)){
            if(Transaction::where('id',$id)->exists()){
                $data = array(
                    'update'    => Transaction::where('id',$id)->first(),
                    'is_update' => TRUE,
                    'data'  => Transaction::paginate(10),
                );
            }
        }else{
            $data = array(
                'data'  => Transaction::paginate(10),
            );
        }
        
        return view('accounts.transaction.index')->with($data);
    }

    public function store(Request $req){

        if(!empty($req->transaction_id)){
            
            if(Transaction::where('id',$req->transaction_id)->exists()){
                if(Transaction::where('mode',$req->mode)->where('id','!=',$req->transaction_id)->doesntExist()){
                    $mode = Transaction::find($req->transaction_id);
                    $mode->mode = $req->mode;
                    $mode->save();

                    return response()->json([
                        'success'   => 'Transaction mode updated successfully',
                        'redirect'  => route('accounts.customer_accounts.transactions.show'),
                    ]);
                }
            }
        }else{
            
            if(Transaction::where('mode',$req->mode)->doesntExist()){
                $mode = new Transaction;
                $mode->mode = $req->mode;
                $mode->save();

                return response()->json([
                    'success'   => 'Transaction mode added successfully',
                    'redirect'  => route('accounts.customer_accounts.transactions.show'),
                ]);
            }
        }

        return response()->json([
            'error' => 'Transaction mode already exists',
        ]);

    }

    public function delete($id){
        if(!empty($id)){
            if(Transaction::where('id',$id)->exists()){
                Transaction::where('id',$id)->delete();
                
                return response()->json([
                    'success'   => 'Transaction mode deleted successfully',
                    'redirect'  => route('accounts.customer_accounts.transactions.show'),
                ]);
            }
        }
    }
}
