<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntryReason;

class EntryReasonController extends Controller
{
    public function index(){
        $data = array(
            'data'  => EntryReason::paginate(10),
        );
        return view('accounts.entries_reason.index')->with($data);
    }

    public function store(Request $req){
        
        if(empty($req->reason_id)){
            if(EntryReason::where('reason',$req->reason)->doesntExist()){
                $reason = new EntryReason;
                $reason->reason =  $req->reason;
                $reason->save();

                return response()->json([
                    'success'   => 'Reason Added successfully',
                    'reload'    => TRUE,
                ]);
            }
        }else{
            if(EntryReason::where('id',$req->reason_id)->exists()){
                if(EntryReason::where('reason',$req->reason)->where('id','!=',$req->reason_id)->doesntExist()){
                    $reason = EntryReason::find($req->reason_id);
                    $reason->reason = $req->reason;
                    $reason->save();

                    return response()->json([
                        'success'   => 'Reason updated successfully',
                        'redirect'    => route('accounts.customer_accounts.reasons.show'),
                    ]);
                }
            }
        }
        return response()->json([
            'error' => 'Reason already exists',
        ]);
    }

    public function edit($id){
        if(EntryReason::where('id',$id)->exists()){
            $data = array(
                'data'  => EntryReason::paginate(10),
                'update'    => EntryReason::where('id',$id)->first(),
                'is_update' => TRUE,
            );
            return view('accounts.entries_reason.index')->with($data);
        }
        return redirect()->back();
    }

    public function delete($id){
        if(EntryReason::where('id',$id)->exists()){
            EntryReason::where('id',$id)->delete();

            return response()->json([
                'success'   => 'Reason deleted successfully',
                'reload'    => TRUE,
            ]);
        }
    }
}
