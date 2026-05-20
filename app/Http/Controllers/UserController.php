<?php

namespace App\Http\Controllers;

use App\CustomField;
//use App\Order;
use App\Plan;
use App\User;
//use App\UserCompany;
use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Spatie\Permission\Models\Role;
use App\DashboardIcon;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {

        $user = \Auth::user();
        // if(\Auth::user()->can('manage user'))
        // {
            // if(\Auth::user()->type == 'super admin')
            // {
            //     $users = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'company')->get();
            // }
            // else
            // {
            // }
            $users = User::where('created_by', '=', $user->creatorId())->where('type', '!=', 'client')->where('delete_status',1)->get();

            return view('user.index')->with('users', $users);
        // }
        // else
        // {
        //     return redirect()->back();
        // }

    }


    public function create()
    {
        $customFields = CustomField::where('module', '=', 'user')->get();

        $user  = \Auth::user();
        $roles = Role::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        // if(\Auth::user()->can('create user'))
        // {
            return view('user.create', compact('roles', 'customFields'));
        // }
        // else
        // {
        //     return redirect()->back();
        // }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('create user'))
        {
            if(\Auth::user()->type == 'super admin')
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:users',
                                       'password' => 'required|min:6',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $user               = new User();
                $user['name']       = $request->name;
                $user['email']      = $request->email;
                $user['password']   = Hash::make($request->password);
                $user['type']       = 'company';
                $user['lang']       = 'en';
                $user['created_by'] = \Auth::user()->creatorId();
                $user['plan']       = Plan::first()->id;
                $user->save();
                CustomField::saveData($user, $request->customField);

                $role_r = Role::findByName('company');
                $user->assignRole($role_r);

            }
            else
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:users',
                                       'password' => 'required|min:6',
                                       'role' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }


                $objUser    = \Auth::user();
                $total_user = $objUser->countUsers();
                $plan       = Plan::find($objUser->plan);
                if($total_user < $plan->max_users || $plan->max_users == -1)
                {
                    $role_r                = Role::findById($request->role);
                    $request['password']   = Hash::make($request->password);
                    $request['type']       = $role_r->name;
                    $request['lang']       = 'en';
                    $request['created_by'] = \Auth::user()->creatorId();

                    $user = User::create($request->all());
                    CustomField::saveData($user, $request->customField);

                    $user->assignRole($role_r);
                }
                else
                {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                }
            }


            return redirect()->route('users.index')->with(
                'success', 'User successfully added.'
            );
        }
        else
        {
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $user  = \Auth::user();

        $roles = Role::where('created_by', '=', $user->creatorId())->get()->pluck('name', 'id');
        if(\Auth::user()->can('edit user'))
        {
            $user              = User::findOrFail($id);
            $user->customField = CustomField::getData($user, 'user');
            $customFields      = CustomField::where('module', '=', 'user')->get();

            return view('user.edit', compact('user', 'roles', 'customFields'));
        }
        else
        {
            return redirect()->back();
        }

    }


    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('edit user'))
        {
            if(\Auth::user()->type == 'super admin')
            {
                $user = User::findOrFail($id);

                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:120',
                                       'email' => 'required|email|unique:users,email,' . $id,
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $input = $request->all();
                $user->fill($input)->save();
                CustomField::saveData($user, $request->customField);

                return redirect()->route('users.index')->with(
                    'success', 'User successfully updated.'
                );
            }
            else
            {
                $user = User::findOrFail($id);
                $this->validate(
                    $request, [
                                'name' => 'required|max:120',
                                'email' => 'required|email|unique:users,email,' . $id,
                                'role' => 'required',
                            ]
                );

                $role          = Role::findById($request->role);
                $input         = $request->all();
                $input['type'] = $role->name;
                $user->fill($input)->save();

                CustomField::saveData($user, $request->customField);

                $roles[] = $request->role;
                $user->roles()->sync($roles);

                return redirect()->route('users.index')->with(
                    'success', 'User successfully updated.'
                );
            }
        }
        else
        {
            return redirect()->back();
        }
    }


    public function destroy($id)
    {   
        if(User::where('id',$id)->exists()){
            User::where('id',$id)->delete();

            return response()->json([
                'success'   => 'User Successfully Deleted',
                'reload'    => TRUE,
            ]);
        }
    }

    public function profile()
    {
        $userDetail              = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'user');
        $customFields            = CustomField::where('module', '=', 'user')->get();

        return view('user.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user       = User::findOrFail($userDetail['id']);
        $this->validate(
            $request, [
                        'name' => 'required|max:120',
                        'email' => 'required|email|unique:users,email,' . $userDetail['id'],
                    ]
        );

        if(!empty($request->profile))
        {   
            $fileName = time().'.'.$request['profile']->getClientOriginalExtension();
            $request->file('profile')->move(public_path('uploads/profile_images'), $fileName); 
            
            $user['avatar'] = $fileName;
        }
        $user['name']  = $request['name'];
        $user['email'] = $request['email'];
        $user->save();
        CustomField::saveData($user, $request->customField);

        return response()->json([
            'success'   => 'Profile updated successfully',
            'reload'    => TRUE,
        ]);
    }

    public function updatePassword(Request $request)
    {
            if(Auth::Check())
            {
                $request->validate(
                    [
                        'current_password' => 'required',
                        'new_password' => 'required|min:6',
                        'confirm_password' => 'required|same:new_password',
                    ]
                );
                $objUser          = Auth::user();
                $request_data     = $request->All();
                $current_password = $objUser->password;
                if(Hash::check($request_data['current_password'], $current_password))
                {
                    $user_id            = Auth::User()->id;
                    $obj_user           = User::find($user_id);
                    $obj_user->password = Hash::make($request_data['new_password']);;
                    $obj_user->save();

                    return response()->json([
                        'success'   => 'Password udpated successfully',
                        'reload'    => TRUE,
                    ]);
                }
                else
                {
                    return response()->json([
                        'error' => 'Please enter correct current password',
                    ]);
                }
            }
            else
            {
                return redirect()->route('profile', \Auth::user()->id)->with('error', __('Something is wrong.'));
            }

    }


    public function backgroundImage(Request $req){
        if(!empty($req['background'])){
           
            $fileName = time().'.'.$req->file('background')->getClientOriginalExtension();
            $req->file('background')->move(public_path('uploads/background_images'), $fileName);

            if(User::where('id',Auth::user()->id)->exists()){
                $user = User::find(Auth::user()->id);
                $user->background_image = $fileName;
                $user->save();

                return response()->json([
                    'success'   => 'Background uploaded successfully',
                    'reload'    => TRUE,
                ]);
            }
        }
    }

    public function removeBackground(){
        if(User::where('id',Auth::user()->id)->exists()){
            User::where('id',Auth::user()->id)->update(['background_image'=>NULL]);

            return response()->json([
                'success'   => 'Backgorund remove successfully',
                'reload'    => TRUE,
            ]);
        }
    }

    public function iconUpload(Request $req){
        if(!empty($req->icon_upload)){
            
            if($req->file('icon_upload')->getClientOriginalExtension() != 'jpg'){
                return response()->json([
                    'error' => 'Please uploadd JPG file',
                ]);
            }
            //rename the file and move 
            $user_id = Auth::User()->id;
            $fileName = $req->icon_slug.'.'.$req->file('icon_upload')->getClientOriginalExtension();
            $req->file('icon_upload')->move(public_path('uploads/dashboard_icons'),$fileName);

            $user_id = Auth::User()->id;


            return response()->json([
                'success'   => 'Icon uploaded successfully',
                'reload'    => TRUE,
            ]);
        }
        
        
        
    }
   public function loginAdminWithoutAuth(Request $request){
        Auth::logout();
        $user= User::find( $request->currentUserId);
           // Log the user in
            Auth::login($user);
            return response()->json([
                'url' => route('dashboard')]);
        
    }
 public function autoLogin(Request $request){
        $userId = $request->get('currentUserId');
        
          // Find the user
        $user = User::find($userId);

        if ($user) {
            // Log the user in
            Auth::login($user);
            
              return response()->json([
                'url' => route('dashboard')]);
        
}

}



    
}
