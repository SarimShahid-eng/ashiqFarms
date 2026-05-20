<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agreement;
use App\Helpers\CommonHelpers;
use App\Schedule;
use App\Head;
use App\Expense;
class BananaAgreementController extends Controller
{
    public function index(){
        $data = array(
            'agreement' => Agreement::with(['childSchedule'=>function($query){
                $query->whereNull('status');
            }])->orderBy('agreement_date','asc')->limit(50)->get(),
        );
        return view('bananaAgreement.index')->with($data);
    }
    //display the contract form
    public function contract(){
        return view('bananaAgreement.contractForm');
    }

    public function store(Request $req){
        $agreement = new Agreement;
        $agreement->user_id          = $req->user_id;
        $agreement->agreement_date   = $req->agreement_date;
        $agreement->end_date         = $req->end_date;
        $agreement->acres            = $req->acres;
        $agreement->agreement_amount = ($req->agreement_amount);
        $agreement->contract_name    = $req->contract_name;
        $agreement->note             = $req->note;
        $agreement->type             = 'banana';

        if(isset($req->image) && !empty($req->image)){
            $img = CommonHelpers::uploadSingleFile($req->image);
            $agreement->image = $img;
        }
        $agreement->save();
        $agreement_id = $agreement->id;

        $arr=[];
        if(!containsOnlyNull($req->due_date)){
            foreach($req->due_date as $key=>$val){
                if(!empty($val)){
                    if(empty($req->due_amount[$key]) || $req->due_amount[$key]=='null'){
                        return response([
                            'error'   => 'Please fill the amount of this date '.get_date($val),
                        ]);
                    }

                    $arr[]=['due_date'=>$val,'due_amount'=> ($req->due_amount[$key]),'agreement_id'=>$agreement_id];
                }
            }
             Schedule::insert($arr);

            // $new_data = Schedule::where('agreement_id',$agreement_id)->get();
            // $head = Head::where('slug','banana_agreement')->first();
            // $subhead = Head::where('slug','banana')->first();

            // $expense = [];

            // foreach($new_data as $data){
            //     $expense[]=['head_id'=>$head->id,'subhead_id'=>$subhead->id,'schedule_id'=>$data->id,'user_id'=>$req->user_id,'acres'=>$req->acres,'total'=>$data->due_amount,'note'=>$req->note,'expense_date'=>$data->due_date,'payment_type'=>0];
            //     $shedule_ids[]=$data->id;
            // }
            // Expense::whereIn('schedule_id',$shedule_ids)->forceDelete();
            // //ading schedule data in expense table
            // Expense::insert($expense);


        }
        return response([
            'success'   => 'Contract added successfully',
            'redirect'  =>   route('banana.show'),
        ]);

    }

    public function edit($id){
        $data = array(
            'edit_data' => Agreement::with('childSchedule')->find($id),
        );
        return view('bananaAgreement.editContractForm')->with($data);
    }

    public function update(Request $req){
        if(Agreement::where('id',$req->id)->exists() && $req->ajax()){

            $date = date('Y-m-d H:i:s');
            $agreement = Agreement::find($req->id);
            $agreement->user_id          = $req->user_id;
            $agreement->agreement_date   = $req->agreement_date;
            $agreement->end_date         = $req->end_date;
            $agreement->acres            = $req->acres;
            $agreement->agreement_amount = $req->agreement_amount;
            $agreement->contract_name    = $req->contract_name;
            $agreement->note             = $req->note;
            $agreement->type             = 'banana';

            if(isset($req->image) && !empty($req->image)){
                $img = CommonHelpers::uploadSingleFile($req->image);
                $agreement->image = $img;
            }elseif(isset($req->old_image) && !empty($req->old_image)){
                $agreement->image = $req->old_image;
            }

            $agreement->save();


            $agreement_id = $req->id;
            // dd($agreement_id);

            $arr=[];
            $pay=[];

            if(!containsOnlyNull(@$req->due_date)){
                foreach(@$req->due_date as $key=>$val){
                    if(!empty($val)){
                        if(empty(@$req->due_amount[$key]) || @$req->due_amount[$key]=='null'){
                            return response([
                                'error'   => 'Please fill the due amount of this date '.get_date($val),
                            ]);
                        }

                        $arr[] = ['due_date'=>@$val,'due_amount'=>@($req->due_amount[$key]),'agreement_id'=>@$agreement_id,'pay_date'=>@$req->pay_date[$key] ,'created_at'=>$date];

                    }

                }
                // dd($arr);
                // dd($req->schedule_id);


                // if(isset($agreement_id)){
                //     $Sch =Schedule::where('agreement_id',$agreement_id)->whereNull('status')->get()->pluck('id');
                //     Schedule::whereIn('id',$Sch)->forceDelete();
                //     Expense::whereIn('schedule_id',$Sch)->forceDelete();

                // }
                if(isset($agreement_id)){
                    $Sch =Schedule::where('agreement_id',$agreement_id)->whereNull('status')->get()->pluck('id');
                    // dd($Sch);
                    Schedule::whereIn('id',$Sch)->forceDelete();
                    // $id = Schedule::where('agreement_id',$agreement_id)->whereNull('status')->get()->pluck('id');
                    // dd($id);
                    // Expense::whereIn('schedule_id',$Sch)->forceDelete();

                }
                // dd($arr);
                Schedule::insert($arr);

                // $new_data = Schedule::where('agreement_id',$agreement_id)->whereNull('status')->get();
                // $head = Head::where('slug','banana_agreement')->first();
                // $subhead = Head::where('slug','banana')->first();

            //     $expense = [];
            //     $shedule_ids =[];
            //    foreach($new_data as $data){
            //         $expense[]=['head_id'=>$head->id,'subhead_id'=>$subhead->id,'schedule_id'=>$data->id,'user_id'=>$req->user_id,'acres'=>$req->acres,'total'=>$data->due_amount,'note'=>$req->note,'expense_date'=>$data->due_date,'payment_type'=>0];
            //         $shedule_ids[]=$data->id;
            //     }

            //     Expense::insert($expense);

                return response([
                    'success'   => 'Contract updated successfully',
                     'reload'    => 'true',
                ]);

            }else{
                // $schedule_ids = Schedule::where('agreement_id', $agreement_id)->get(['id'])->pluck('id')->toArray();
                // Expense::whereIn('schedule_id', $schedule_ids)->update(['note'=>$req->note,'acres'=>$req->acres]);
            }
            return response([
                'success'   => 'Contract updated successfully',
                'reload'    => 'true',
            ]);
            // return redirect()->back();
        }

    }

    public function paid(Request $req){

        if(isset($req->id) && !empty($req->id)){
            if(isset($req->due_date) && !empty($req->due_date)){
                if(isset($req->pay_date) && !empty($req->pay_date)){
                    if(isset($req->status) && !empty($req->status)){
                        $schedule = Schedule::find($req->id);

                        $agreement_id = $schedule->agreement_id;

                        $schedule->due_date = $req->due_date;
                        $schedule->pay_date = $req->pay_date;
                        $schedule->status = $req->status;
                        $schedule->save();

                        $head = Head::where('slug','banana_agreement')->first();
                        $sub_head = Head::where('parent_id',$head->id)->first();

                        $agreement = Agreement::where('id',$agreement_id)->first();

                        // //deleting schedule record form expense
                        // $expense = Expense::where('schedule_id',$req->id)->forceDelete();

                        //update expesne status to paid
                        // Expense::where('schedule_id', $req->id)->update(['payment_type'=>2]);

                        return response([
                            'success'   => 'payment paid successfully',
                        ]);
                    }
                }
            }
        }
        return response([
            'error' => 'Please fill date field',
        ]);
    }

    public function delete($id){
        if(isset($id) && !empty($id)){
            //if exists then delete agreement
            if(Agreement::where('id',$id)->exists()){
                $find = Agreement::find($id);
                $find->forceDelete();
                //if schedule exists then delete schdule
                if(Schedule::where('agreement_id',$id)->exists()){
                    $ids[] = $id;
                    $schedule_ids = Schedule::select('id')->whereIn('agreement_id',$ids)->get();
                    $schedule = Schedule::whereIn('agreement_id',$ids)->forceDelete();

                    // if(Expense::whereIn('schedule_id',$schedule_ids)->exists()){
                    //     $expense = Expense::whereIn('schedule_id',$schedule_ids)->forceDelete();
                    // }
                }
                return response([
                    'success' => 'Agreement delete successfully',
                    'reload'    => TRUE,
                ]);
            }
        }
    }
    //this function display the buttons on header
    public function lateDues(){

        $late = Schedule::where('due_date','<',date('Y-m-d'))->whereNull('status')->get();
        $date =date('Y-m-d');
        $days_10 = date('Y-m-d',strtotime('+10 day'));
        $day = Schedule::whereBetween('due_date',[$date,$days_10])->whereNull('status')->get();
        $html = [];
        // dd(auth()->user()->name);
        if(auth()->user()->name == 'ashiq hussain'){
            if($late->isNotEmpty()){
                // $html .= '<a class="btn red button mr-3" href='.route('reports.late').' target="blank">Late Payments</a>';
                $html[]= 'late';
            }
            if($day->isNotEmpty()){
                // $html .= '<a class="btn green button" href='.route('reports.due').' target="blank">Upcoming Payments</a>';
                $html[]= 'upcoming';
            }
        }
        return $html;

    }

    public function scheduleDelete($id){
        if(!empty($id)){
            //delete schedule from expense
            // if(Expense::where('schedule_id',$id)->exists()){
            //     Expense::where('schedule_id',$id)->forceDelete();
            // }
            //delete schedule form schedule table
            if(Schedule::where('id',$id)->exists()){
                Schedule::where('id',$id)->forceDelete();

                return response()->json([
                    'success'   => 'Schedule deleted successfully',
                    'reload'    => TRUE,
                ]);
            }
        }
        return redirect()->back();
    }

    //print agreement
    public function printAgreement($id){
        if(isset($id) && !empty($id)){
            if(Agreement::where('id',$id)->exists()){
                $data = array(
                    'agreement' => Agreement::with(['childSchedule'])->find($id),
                );
                return view('bananaAgreement.print_agreement')->with($data);
            }
        }
    }

}
