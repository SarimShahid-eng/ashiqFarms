<?php

namespace App\Http\Controllers;

use Ifsnop\Mysqldump\Mysqldump;
use Illuminate\Http\Request;
use App\Head;
use App\User;
use App\Expense;
use App\Exports\EntriesReportExport;
use App\ReportSetting;
use App\Schedule;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Response;
use Illuminate\Support\Facades\File;

use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //
    public function index()
    {

        $user_id = Auth::User()->id;

        $setting = ReportSetting::where('user_id', $user_id)->first();
        $data = array(
            'heads' => Head::where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('user_id', $user_id)->orderBy('head_name')->get(),
            'subheads' => Head::where('parent_id', '!=', 0)->where('child_id', 0)->where('user_id', $user_id)->get(),
            'users' => User::where('id', '!=', Auth::user()->id)->get(),
            'head_ids' => ($setting) ? json_decode($setting->data)->head : [],
            'sub_head_ids' => ($setting) ? json_decode($setting->data)->subhead : [],
            'user_report_id' => @$setting->user_id,
            'user_id' => $user_id,
            'setting' => $setting,
            'users' => User::get(),
        );
        // dd($data['users']);
// dd('ss');
        return view('report.index')->with($data);
    }

    public function subhead($id)
    {

        if (Head::find($id)) {

            $subheads = Head::where('parent_id', $id)->orderBy('head_name')->get();
            $html = '';

            if (count($subheads) > 0) {
                foreach ($subheads as $subhead) {
                    $html .= '<option value=' . $subhead->id . '>' . $subhead->head_name . '</option>';
                }
                return $html;
            } else {
                $html = "<option value='' >No Subheads</option>";
                return $html;
            }

        } else {
            $html = "<option>No data</option>";
            return $html;
        }
    }
    public function thirdhead($id)
    {

        if (Head::find($id)) {

            $childheads = Head::where('child_id', $id)->orderBy('head_name')->get();
            $html = '';

            if (count($childheads) > 0) {
                foreach ($childheads as $childhead) {
                    $html .= '<option value=' . $childhead->id . '>' . $childhead->head_name . '</option>';
                }
                return $html;
            } else {
                $html = "<option value='' >No Child</option>";
                return $html;
            }

        } else {
            $html = "<option>No data</option>";
            return $html;
        }
    }

    public function search($head_id = NULL, $subhead_id = NULL, $child_head_id = NULL,$fourth_head_id =Null, Request $req)
    {

        $expense = Expense::with(['parentHead', 'parentSubhead', 'parentChildSubhead','parentForthSubhead', 'parentUser']);
        $report = "All Expense/Income Report";

        if (Auth::user()->type == 'company') {
            if (isset($req->users) && $req->users != NULL && $req->users != 'all') {
                if (isset($req->users) && $req->users != NULL) {
                    $expense = $expense->where('user_id', $req->users); //if user is selected display the specific user report
                } else {
                    $expense = $expense->where('user_id', $req->user_id); //if user is not selected than display the admin report only
                }
            }
        } else {
            $expense = $expense->where('user_id', $req->user_id);
        }

        if (isset($req->head) && $req->head != NULL) {
            $expense = $expense->where('head_id', $req->head);
        }
        if (isset($req->subhead) && $req->subhead != NULL) {
            $expense = $expense->whereIn('subhead_id', $req->subhead);
        }
        if (isset($req->child_subhead) && $req->child_subhead != NULL) {
            $expense = $expense->WhereIn('child_subhead_id', $req->child_subhead);
        }
        if (isset($req->forth_subhead) && $req->forth_subhead != NULL) {
            $expense = $expense->WhereIn('forth_head', $req->forth_subhead);
        }
        if (isset($req->from_date) && isset($req->to_date)) {
            $from_date = $req->from_date;
            $to_date = $req->to_date;
        }
        //when user click on the icons from dashboard then get the data according this condition
        if (isset($head_id) && $head_id != NULL) {
            $expense = $expense->where('head_id', $head_id);
            $from_date = date('Y-m-15', strtotime('-15 day'));
            $to_date = date('Y-m-15');
        }
        if (isset($subhead_id) && $subhead_id != NULL) {
            $expense = $expense->where('subhead_id', $subhead_id);
        }
        if (isset($child_head_id) && $subhead_id != NULL) {
            $expense = $expense->where('child_subhead_id', $child_head_id);
        }

        if (isset($req->type) && $req->type != NULL) {
            if ($req->type == 0) {
                $type = 0;
                $report = "Income Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 1) {
                $type = 1;
                $report = "Expense Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 2) {
                $type = 2;
                $report = "Paid Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 3) {
                $type = 3;
                $report = "All Expense/Income Report";
            }
        } else {
            $type = 3;

        }
        //check it edit is set or not
        if (isset($req->edit) && $req->edit != NULL) {
            $edit = TRUE;
        }

        $expense = $expense->whereDate('expense_date', '>=', $from_date)
            ->whereDate('expense_date', '<=', $to_date)
            ->orderBy('expense_date', 'asc')
            ->get();

        if (empty($req->subhead)) {
            $req->subhead = Head::where('parent_id', $req->head)->pluck('id')->all();
        }

        if ($expense->isNotEmpty()) {
            $data = array(
                'head' => Head::where('id', $req->head)->first(),
                'subhead' => (!empty($req->subhead)) ? Head::whereIn('id', $req->subhead)->get()->implode('head_name', ', ') : '',
                'from_date' => $req->from_date,
                'to_date' => $req->to_date,
                'expense' => $expense,
                'report' => $report,
                'type' => $type,
                'edit' => (isset($edit)) ? TRUE : NULL,
                'users'=>User::all()
            );
            return view('report.report')->with($data);
           
        } else {
            return redirect()->back()->with('error', 'No Record Found');
        }



    }
    // public function search(Request $req){

    //     $expense  = Expense::with(['parentHead','parentSubhead','parentChildSubhead','parentUser']);
    //     $report = "All Expense/Income Report";

    //     if(Auth::user()->type == 'company'){
    //         if(isset($req->users) && $req->users != NULL && $req->users != 'all'){
    //             if(isset($req->users) && $req->users != NULL){
    //                 $expense = $expense->where('user_id',$req->users);//if user is selected display the specific user report
    //             }else{
    //                 $expense = $expense->where('user_id',$req->user_id);//if user is not selected than display the admin report only
    //             }
    //         }
    //     }else{
    //         $expense = $expense->where('user_id',$req->user_id);
    //     }

    //     if(isset($req->head) && $req->head != NULL){
    //         $expense = $expense->where('head_id',$req->head);
    //     }
    //     if(isset($req->subhead) && $req->subhead != NULL){
    //         $expense = $expense->whereIn('subhead_id',$req->subhead);
    //     }
    //     if(isset($req->child_subhead) && $req->child_subhead != NULL){
    //         $expense = $expense->WhereIn('child_subhead_id',$req->child_subhead);
    //     }

    //     if(isset($req->type) && $req->type != NULL){
    //         if($req->type == 0){
    //             $type = 0;
    //             $report = "Income Report";
    //             $expense = $expense->where('payment_type',$type);
    //         }elseif($req->type == 1){
    //             $type = 1;
    //             $report = "Expense Report";
    //             $expense = $expense->where('payment_type',$type);
    //         }elseif($req->type == 2){
    //             $type = 2;
    //             $report = "All Expense/Income Report";
    //         }
    //     }else{
    //         $type = 2;
    //     }
    //     //check it edit is set or not
    //     if(isset($req->edit) && $req->edit != NULL){
    //         $edit = TRUE;
    //     }

    //     $expense = $expense->whereDate('expense_date','>=',$req->from_date)
    //                 ->whereDate('expense_date','<=',$req->to_date)
    //                 ->orderBy('expense_date','asc')
    //                 ->get();

    //     if(empty($req->subhead)){
    //         $req->subhead =Head::where('parent_id',$req->head)->pluck('id')->all();
    //     }

    //     if($expense->isNotEmpty()){
    //         $data = array(
    //             'head'      =>  Head::where('id',$req->head)->first(),
    //             'subhead'   => (!empty($req->subhead)) ? Head::whereIn('id',$req->subhead)->get()->implode('head_name', ', ') : '',
    //             'from_date' => $req->from_date,
    //             'to_date'   => $req->to_date,
    //             'expense'   => $expense,
    //             'report'    => $report,
    //             'type'      => $type,
    //             'edit'      => (isset($edit))?TRUE:NULL,
    //         );

    //         return view('report.report')->with($data);
    //     }else{
    //         return redirect()->back()->with('error','No Record Found');
    //     }



    // }

    public function column_color($id)
    {
        if (!empty($id) && isset($_GET['colorCode'])) {
            $color = Expense::find($id);
            if ($_GET['type'] == 'background') {
                $color->column_color = $_GET['colorCode'];
            }
            if ($_GET['type'] == 'fonts') {
                $color->column_fonts = $_GET['colorCode'];
            }
            $color->save();
        }

    }

    public function update(Request $req)
    {
 
        if (isset($req->id)) {
            $updateExpense = function ($instance, $req) {
            $instance->expense_date = $req->date;
            $instance->head_id = $req->first_head;
            $instance->subhead_id = $req->second_head;
            $instance->child_subhead_id = $req->third_head;
            $instance->forth_head = $req->forth_head;
            $instance->work = $req->work;
            $instance->acres = $req->acres;
            $instance->quantity = $req->quantity;
            $instance->material = $req->material;
            $instance->unit_rate = $req->rate;
            $instance->total = $req->total;
            $instance->payment_type = $req->type;
            $instance->note = $req->note;
            $instance->save();
    };
    //             // Update the targeted expense entry
    $expense = Expense::find($req->id);

  // Check if a second user entry should be updated
    if (!empty($req->user_id) && $expense) {
        // make sure the entry details matches
        $second_expense = Expense::where('user_id', $req->user_id)
            ->where('expense_date',$expense->expense_date)
            ->where('head_id',$expense->head_id)
            ->where('subhead_id',$expense->subhead_id)
            ->where('child_subhead_id',$expense->child_subhead_id)
            ->where('forth_head',$expense->forth_head)
            ->where('work',$expense->work)
            ->where('acres',$expense->acres)
            ->where('quantity',$expense->quantity)
            ->where('material',$expense->material)
            ->where('unit_rate',$expense->unit_rate)
            ->where('total',$expense->total)
            ->where('payment_type',$expense->payment_type)
            ->where('note',$expense->note)
            ->where('created_at',$expense->created_at)
            ->first();
               if($second_expense){
                  $updateExpense($second_expense, $req);
                 }
                  $updateExpense($expense, $req);
    }else{
          $updateExpense($expense, $req);
    }
            $add_row = Expense::with(['parentHead', 'parentSubhead', 'parentChildSubhead', 'parentUser','parentForthSubhead'])->where('id', $req->id)->first();

            return view('report.updated_row')->with(['expense' => $add_row]);
        }

    }

    public function headSubhead()
    {
        $data = array(
            'heads' => Head::with(['sub'])->where('parent_id', 0)->toArray(),
        );

        return view("report.headsubhead")->with($data);
    }

    public function row(Request $req)
    {
        $expenses = Expense::with('parentUser')->find($req->id);
        $data = array(
            'expense' => $expenses,
            'heads' => Head::where('id', '!=', 0)->where('parent_id', 0)->where('child_id', 0)->where('forth_head', 0)->where('user_id', Auth::user()->id)->get(),

            'second_heads' => Head::where('parent_id', $expenses->head_id)->where('user_id', Auth::user()->id)->get(),

            'third_heads' => Head::where('child_id', $expenses->subhead_id)->where('parent_id', 0)->where('forth_head', 0)->where('user_id', Auth::user()->id)->get(),

            'fourth_heads' => Head::where('forth_head',  $expenses->child_subhead_id)->where('parent_id', 0)->where('child_id', 0)->where('user_id', Auth::user()->id)->get(),
        );
        return view('report.row')->with($data);
    }

    public function delete(Request $req)
    {
        if (isset($req->id)) {
            Expense::destroy($req->id);
        }
    }
    //this function shows the report of late dues
    public function late()
    {
        $data = array(
            'late' => Schedule::with(['parentAgreement'])->where('due_date', '<', date('Y-m-d'))->whereNull('status')->orderBy('due_date', 'asc')->get(),
        );

        return view('report.late_report')->with($data);
    }
    //this fucntion show the report of
    public function due()
    {
        $date = date('Y-m-d');
        $days_10 = date('Y-m-d', strtotime('+10 day'));
        $data = array(
            'dues' => schedule::with(['parentAgreement'])->whereBetween('due_date', [$date, $days_10])->whereNull('status')->orderBy('due_date', 'asc')->get(),
        );

        return view('report.due_report')->with($data);
    }
    //this function set the status to paid of specified id
    public function latePay(Request $req)
    {
        if (Schedule::where('id', $req->id)->exists()) {
            $pay = Schedule::find($req->id);
            Expense::where('schedule_id', $req->id)->forceDelete();
            $pay->pay_date = $req->date;
            $pay->status = 'paid';
            $pay->save();
        }
    }

    public function check(Request $req)
    {
        $settingArr = array();
        (!empty($req->heads)) ? $settingArr['head'] = $req->heads : $settingArr['head'] = NULL;
        (!empty($req->subheads)) ? $settingArr['subhead'] = $req->subheads : $settingArr['subhead'] = NULL;

        $find_user = ReportSetting::where('user_id', $req->id)->first();

        if ($find_user) {
            $arr = ['user_id' => $req->id, 'data' => json_encode($settingArr), 'updated_at' => date('Y-m-d H:i:s')];
            ReportSetting::where('user_id', $req->id)->update($arr);
        } else {
            $arr = ['user_id' => $req->id, 'data' => json_encode($settingArr), 'updated_at' => date('Y-m-d H:i:s')];
            ReportSetting::insert($arr);
        }

        return response([
            'success' => 'Checkbox updated successfully',
        ]);
    }
    public function moveEntryToAnotherUser(Request $req){
        // $validate=$req->validat
        $entryId=$req->id;
        // dd($entr)
        $user_id=$req->user_id;
        $original = Expense::findOrFail($entryId);
       $newExpense = $original->replicate();     // copies everything
        $newExpense->user_id = $user_id;
        $newExpense->is_move = 1;
        $newExpense->save();
        
    return response()->json([
        'success' => true,
        'message' => 'Expense moved to new user successfully'
    ]);
    
    }
    //move the entries to admin
    public function move(Request $req)
    {

        Expense::where('id',$req->id)->update(['is_move'=>($req->boolean=="false") ? 0 : 1]);
        // if (Auth::user()->type == 'company') {

        //     $admin_id = Auth::User()->id;
        //     $ids = $req->ids;

        //     Expense::whereIn('id', $ids)->update(['user_id' => $admin_id]);
        // }

    }


    public function reportExportCsv(Request $req)
    {

        $expense = Expense::with(['parentHead', 'parentSubhead', 'parentChildSubhead', 'parentUser']);
        $report = "All Expense/Income Report";

        if (Auth::user()->type == 'company') {
            if (isset($req->users) && $req->users != NULL && $req->users != 'all') {
                if (isset($req->users) && $req->users != NULL) {
                    $expense = $expense->where('user_id', $req->users); //if user is selected display the specific user report
                } else {
                    $expense = $expense->where('user_id', $req->user_id); //if user is not selected than display the admin report only
                }
            }
        } else {
            $expense = $expense->where('user_id', $req->user_id);
        }

        if (isset($req->head) && $req->head != NULL) {
            $expense = $expense->where('head_id', $req->head);
        }
        if (isset($req->subhead) && $req->subhead != NULL) {
            $expense = $expense->whereIn('subhead_id', $req->subhead);
        }
        if (isset($req->child_subhead) && $req->child_subhead != NULL) {
            $expense = $expense->WhereIn('child_subhead_id', $req->child_subhead);
        }
        if (isset($req->child_subhead) && $req->child_subhead != NULL) {
            $expense = $expense->WhereIn('child_subhead_id', $req->child_subhead);
        }
        if (isset($req->from_date) && isset($req->to_date)) {
            // $from_date = $req->from_date;
            // $to_date = $req->to_date;
            $expense = $expense->WhereBetween('expense_date', [$req->from_date, $req->to_date]);
        }

        if (isset($req->type) && $req->type != NULL) {
            if ($req->type == 0) {
                $type = 0;
                $report = "Income Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 1) {
                $type = 1;
                $report = "Expense Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 2) {
                $type = 2;
                $report = "Paid Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 3) {
                $type = 3;
                $report = "All Expense/Income Report";
            }
        } else {
            $type = 3;

        }

        $expense = $expense->orderBy('expense_date', 'asc')->get();
        // dd($expense[0]);
        $headers = array(
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=download.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        );

        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path() . "/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename = public_path("files/download.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            "#",
            "Expense Date",
            "Heads",
            "Subhead",
            "Child Head",
            "Fourth Head",
            "Work",
            "Acres",
            "Material",
            "Qty",
            "Rate",
            "Total",
            "Type",
            "Note",
        ]);

        $expens = 0;
        $income = 0;
        $paid = 0;
        $payment_type = "Income";
        //adding the data from the array
        foreach ($expense as $key => $data) {

            if ($data->payment_type == 1) {
                $expens += $data->total;
            } elseif ($data->payment_type == 2) {
                $paid += $data->total;
            } else {
                $income += $data->total;
            }

            // if$data->payment_type == )
            if ($data->payment_type == 1) {
                $payment_type = "Expense";
            } elseif ($data->payment_type == 2) {
                $payment_type = "Paid";
            } else {
                $payment_type = "Income";
            }

            fputcsv($handle, [
                $key + 1,
                date('d-M-Y', strtotime($data->expense_date)),
                @$data->parentHead->head_name,
                @$data->parentsubhead->head_name,
                @$data->parentChildSubhead->head_name,
                @$data->work,
                @$data->acres,
                $data->material,
                @round(@$data->quantity),
                round(@$data->unit_rate),
                round(@$data->total),
                @$data->payment_type = $payment_type,
                //($data->payment_type == 1) ? "Expense" : "Income",
                @$data->note,
            ]);

        }
        $total = round($expens - ($paid + $income));

        fputcsv($handle, ["\t", "\t", "\t", "\t", "\t", "\t", "\t", "\t", "\t", "\t", $total, "\t", "\t", "\t"]);
        fclose($handle);

        return Response::download($filename, "download.csv", $headers);

    }

    public function reportExportExcel(Request $req)
    {
// dd($req->all());
        $expense = Expense::with(['parentHead', 'parentSubhead', 'parentChildSubhead', 'parentUser','parentForthSubhead']);
        $report = "All Expense/Income Report";

        if (Auth::user()->type == 'company') {
            if (isset($req->users) && $req->users != NULL && $req->users != 'all') {
                if (isset($req->users) && $req->users != NULL) {
                    $expense = $expense->where('user_id', $req->users); //if user is selected display the specific user report
                } else {
                    $expense = $expense->where('user_id', $req->user_id); //if user is not selected than display the admin report only
                }
            }
        } else {
            $expense = $expense->where('user_id', $req->user_id);
        }

        if (isset($req->head) && $req->head != NULL) {
            $expense = $expense->where('head_id', $req->head);
        }
        if (isset($req->subhead) && $req->subhead != NULL) {
            $expense = $expense->whereIn('subhead_id', $req->subhead);
        }
        if (isset($req->child_subhead) && $req->child_subhead != NULL) {
            $expense = $expense->WhereIn('child_subhead_id', $req->child_subhead);
        }
        if (isset($req->child_subhead) && $req->child_subhead != NULL) {
            $expense = $expense->WhereIn('child_subhead_id', $req->child_subhead);
        }
        if (isset($req->from_date) && isset($req->to_date)) {
            // $from_date = $req->from_date;
            // $to_date = $req->to_date;
            $expense = $expense->WhereBetween('expense_date', [$req->from_date, $req->to_date]);
        }

        if (isset($req->type) && $req->type != NULL) {
            if ($req->type == 0) {
                $type = 0;
                $report = "Income Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 1) {
                $type = 1;
                $report = "Expense Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 2) {
                $type = 2;
                $report = "Paid Report";
                $expense = $expense->where('payment_type', $type);
            } elseif ($req->type == 3) {
                $type = 3;
                $report = "All Expense/Income Report";
            }
        } else {
            $type = 3;

        }
        $file_name = $req->from_date . '-' . $req->to_date . '.xlsx';
        $expense = $expense->orderBy('expense_date', 'asc')->get();
        return Excel::download(new EntriesReportExport($expense), $file_name);
        // $html = '';
        // $html .= "<table>
        //             <thead>
        //                 <th >#</th>
        //                 <th>Expense Date</th>
        //                 <th>Heads</th>
        //                 <th>Subhead</th>
        //                 <th>Child Head</th>
        //                 <th>Work</th>
        //                 <th>Acres</th>
        //                 <th>Material</th>
        //                 <th>Qty</th>
        //                 <th>Rate</th>
        //                 <th>Total</th>
        //                 <th>Type</th>
        //                 <th>Note</th>
        //                 <th>Added BY</th>
        //             </thead>";

        // $expens = 0;
        // $income = 0;
        // $paid = 0;
        // $payment_type = "Income";
        // //adding the data from the array
        // foreach ($expense as $key=>$data) {

        //     if($data->payment_type == 1){
        //         $expens += $data->total;
        //     }elseif($data->payment_type == 2){
        //         $paid += $data->total;
        //     }else{
        //         $income += $data->total;
        //     }

        //     // if$data->payment_type == )
        //     if($data->payment_type == 1){
        //         $payment_type = "Expense";
        //     }elseif($data->payment_type == 2){
        //         $payment_type = "Paid";
        //     }else{
        //         $payment_type = "Income";
        //     }

        //     $html .= "<tr>
        //                 <td>".($key+1)."</td>
        //                 <td>".date('d-M-Y',strtotime($data->expense_date))."</td>
        //                 <td>".@$data->parentHead->head_name."</td>
        //                 <td>".@$data->parentsubhead->head_name."</td>
        //                 <td>".@$data->parentChildSubhead->head_name."</td>
        //                 <td>".@$data->work."</td>
        //                 <td>".@$data->acres."</td>
        //                 <td>".$data->material."</td>
        //                 <td>".round(@$data->quantity)."</td>
        //                 <td>".round(@$data->unit_rate)."</td>
        //                 <td>".round(@$data->total)."</td>
        //                 <td>".@$data->payment_type = $payment_type."</td>
        //                 <td>".@$data->note."</td>
        //                 <td>".@$data->parentUser->name."</td>
        //             </tr>";
        // }
        // $html .= "</table>";

        // header("Content-Type: application/xls");
        // header("Content-Disposition:attachment; filename=download.xls");
        // echo $html;
    }
    function download()
    {
        $mysqlHostName = env('DB_HOST');
        $mysqlUserName = env('DB_USERNAME');
        $mysqlPassword = env('DB_PASSWORD');
        $DbName = env('DB_DATABASE');
        $backup_name = "mybackup.sql";
        $tables = array("account", "agreements", "balances", "banks", "bank_branches", "customers", "customer_account_report_settings", "customer_banks_branches", "custom_fields", "custom_field_values", "entries_reason", "expenses", "heads", "migrations", "password_resets", "settings", "plans", "report_settings", "schedules", "transactions"); //here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();


        $output = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for ($count = 0; $count < $total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);
                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "'" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
        $file_handle = fopen($file_name, 'w+');
        fwrite($file_handle, $output);
        fclose($file_handle);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file_name));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_name));
        flush();
        readfile($file_name);
        unlink($file_name);
    }
    function import_db_view()
    {

        return view('import_db.index');
    }
    function import_db(Request $request)
    {

        $filePath = public_path('ashiq.sql'); // Specify the full path to the file within the "public" folder

        if (File::exists($filePath)) {
            File::delete($filePath);
            if ($request->hasFile('file')) {
                $file = $request->file;
                $filename = 'ashiq.sql';
                $destinationPath = public_path();
                $file->move($destinationPath, $filename);
                $this->import_data_query();
                return redirect()->back()->with('success', 'Data');
            }
        } else {
            $file = $request->file;
            $filename = 'ashiq.sql';
            $destinationPath = public_path();
            $file->move($destinationPath, $filename);
            $this->import_data_query();
            return redirect()->back()->with('success', 'data');
        }
    }
    function import_data_query()
    {
        $tables = array("account", "agreements", "balances", "banks", "bank_branches", "customers", "customer_account_report_settings", "customer_banks_branches", "expenses", "custom_field_values", "custom_fields", "entries_reason", "heads", "migrations", "password_resets", "settings", "plans", "report_settings", "schedules", "transactions");

        // Iterate through the tables and drop each one
        foreach ($tables as $table) {

            $table_name = $table;
            Schema::dropIfExists($table_name);
        }
        $sql_file = public_path('ashiq.sql');
        // Read the entire file into a string
        $fileContents = file_get_contents($sql_file);
        $first_data = str_replace(["\t", "\n", "\r"], '', $fileContents);
        $second_data = str_replace("''", "NULL", $first_data);

        $dataArray = explode(';', $second_data);
        // print_r( $dataArray);
        // die();
        foreach ($dataArray as $data) {

            if ($data != "") {
                DB::statement($data);
            }
        }
    }
}
