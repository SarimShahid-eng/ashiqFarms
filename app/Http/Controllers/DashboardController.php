<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Agreement;
use App\Schedule;
use App\BankBranch;
use Illuminate\Http\Request;
use App\DashboardIcon;
use App\Head;
use App\User;
use Auth;
use App\DashboardImage;
use DB;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Auth::user();
           $user_id = Auth::user()->id;
          $data = [
            'users' => User::where('created_by', '=', auth()->user()->creatorId())
                ->where('type', '!=', 'client')
                ->where('delete_status', 1)
                ->get(),
            'total_agreements' => [],
                        'dashboard_image'=>DashboardImage::where('user_id',$user_id)->first(),
        ];
        if(Auth::user()->type !== "company" && !Auth::user()->can('show dashboard')){
             return view('errors/404');
            
        }
    
        return view('dashboard.index')->with($data);
 
    }
    public function some_changes(){
        $expenses = Expense::with(['parentHead','parentSubhead','parentChildSubhead','parentUser'])->where('is_move',1)->orderBy('expense_date','asc');

            if(@$_GET['view']){
                $data =['expense'=>$expenses->get()];
                return view('report.list_some_changes')->with($data);

            }
        return response([
            'expenses' => $expenses->count()
        ]);
    }

    public function settings(){

        $data=['title'=>'Home'];
        return view('user.settings')->with($data);

    }


}

