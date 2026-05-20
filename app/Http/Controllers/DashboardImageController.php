<?php

namespace App\Http\Controllers;

use DB;
use App\Head;
use App\Expense;
use App\Schedule;
use App\Agreement;
use App\BankBranch;
use App\DashboardIcon;
use App\DashboardImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardImageController extends Controller
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

 public function store(Request $request)
    {
        $validate = $request->validate([
            'image' => 'required',
        ]);
        $loggedInUserId=Auth::user()->id;
        if (!empty($validate['image'])) {

            $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('uploads/dashboard_image'), $fileName);

            if (DashboardImage::where('user_id', $loggedInUserId)->exists()) {
                $dashboardUserImage = DashboardImage::where('user_id', $loggedInUserId)->firstOrFail();
                $dashboardUserImage->image = $fileName;
                $dashboardUserImage->save();

                return response()->json([
                    'success'   => 'Dashboard UserImage upload updated successfully',
                    'reload'    => TRUE,
                ]);
            }else{
                DashboardImage::create([
                    'user_id'=>$loggedInUserId,
                    'image'=>$fileName
                ]);
                return response()->json([
                    'success'   => 'Dashboard UserImage upload created successfully',
                    'reload'    => TRUE,
                ]);
            }
        }
    }
}
