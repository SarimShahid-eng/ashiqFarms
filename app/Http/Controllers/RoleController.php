<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;
use App\User;
use App\CustomField;
use App\RoleHasPermission;
use DB;
use App\Helpers\CommonHelpers;
use Illuminate\Support\Str;
class RoleController extends Controller
{

    public function index()
    {
        if(Auth::check() && Auth::user()->type == "company"){

            $roles = Role::where('created_by','=',\Auth::user()->creatorId())->where('created_by','=',\Auth::user()->creatorId())->get();
            return view('role.index')->with('roles', $roles);
        }else{
            return redirect()->back()->with('error','Permission denied.');
        }

    }


    public function create($id=NULL)
    {  
        if($id != NULL){
            $user = User::find($id);

            $role = Role::where('name',$user->type)->first();

            $Permission =\DB::table('role_has_permissions')->where('role_id',$role->id)->pluck('permission_id')->toArray();



            $data = array(
                'user' =>  $user,
                'permissions' => Permission::all()->pluck('name', 'id')->toArray(),
                'role_has_permission' => $Permission,
                'update'    => TRUE,
            );
      
            return view('role.create')->with($data);
        }
            $user = \Auth::user();

                $permissions = Permission::all()->pluck('name', 'id')->toArray();
// dd($permissions);
            return view('role.create', ['permissions' => $permissions]);


    }


    public function store(Request $request)
    {    
        // dd('woekd');

        $r =$request->all();
        if(!$request->id){
            $this->validate(
                $request, [
                            'name' => 'required|max:120|unique:roles,name,NULL,id,created_by,'.\Auth::user()->creatorId(),
                            'permissions' => 'required',
                            'email' => 'required|email|unique:users',
                            'password' => 'required|min:6',
                            // 'avatar'     => 'mimes:jpeg,jpg,png,|max:10000'
                        ]
            );
        }else{
            $query = DB::table('users')->where('email',$request->email)->where('id','!=',$request->id)->first();

            if($query){
                return response()->json([
                    'error' => "Email already exists",
                    'reload' => false,
                ]);
            }

        }
            $created = 'created';
            $permissions = $request['permissions'];

            if(!$request->id){
                $name        = $request['name'];
                $role        = new Role();
                $role->name  = $name.'_'.strtotime(date('y-m-d H:i:s'));
                $role->created_by=Auth::user()->creatorId();
                $role->save();
            }else{
                    $user = User::find($request->id);
                    $role = Role::where('name',$user->type)->first();
                    \DB::table('role_has_permissions')->where('role_id',$role->id)->delete();
                    $created = 'Updated';
            }



            if(!empty($permissions)){
                foreach($permissions as $permission)
            {
                $p    = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }
            }

            $objUser    = Auth::user();
            $role_r     = Role::findById($role->id);

            if($request->password){
                $password = \Hash::make($request->password);
            }
           
            if($request->hasFile('avatar')){
                $fileName = time().'.'.$request->file('avatar')->extension(); 
                $request->file('avatar')->move(public_path('uploads/profile_images'), $fileName); 
                @unlink(public_path('uploads/profile_images/').$user->avatar);
                $r['avatar'] =$fileName;
            }else{
                unset($r['avatar']);
            }


            if(!$request->id){
                $user = new User;
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->password = $password;
                $user->type       = $role_r->name;
                $user->avatar =   (isset($fileName)) ? $fileName : '';
                $user->lang       = 'en';
                $user->created_by = \Auth::user()->creatorId();
                $user->session_id = Str::random(40);
                $user->save();

            }else{
               
                unset($r['_token']);
                unset($r['permissions']);

                if(!$request['password']){
                    unset($r['password']);
                }else{
                    $r['password'] = \Hash::make($request->password);
                }
                // if($request->hasFile('avatar')){
                    
                //     // $fileName = time().'.'.$request['avatar']->getClientOriginalExtension();
                  
                //     $fileName =CommonHelpers::uploadSingleFile($request->file('avatar'));
                //     dd($fileName);
                //     // $request->file('avatar')->storeAs('public/uploads/profile_images',$fileName );
                //     @unlink(public_path('uploads/profile_images/').$user->avatar);
                   
                // }
                
                User::where('id',$request->id)->update($r);

            }

            CustomField::saveData($user, $request->customField);
            $user->assignRole($role_r);

            return response()->json([
                'success' => 'User   '. $created . ' successfully!',
                'redirect' => route('users.index')
            ]);

    }

    public function edit($id = NULL)
    {
        return "DONE";
        // if(\Auth::user()->can('edit role')){

        //     $user = \Auth::user();
        //     if($user->type == 'super admin')
        //     {
        //         $permissions = Permission::all()->pluck('name', 'id')->toArray();
        //     }else{
        //         $permissions = new Collection();
        //         foreach ($user->roles as $role1) {
        //             $permissions = $permissions->merge($role1->permissions);
        //         }
        //         $permissions = $permissions->pluck('name','id')->toArray();
        //     }

        //     return view('role.edit', compact('role', 'permissions'));
        // }else{
        //     return redirect()->back()->with('error','Permission denied.');
        // }


    }

    public function update(Request $request, Role $role)
    {
        if(\Auth::user()->can('edit role')){
            $this->validate(
                $request, [
                            'name' => 'required|max:100|unique:roles,name,'. $role['id'].',id,created_by,'.\Auth::user()->creatorId(),
                            'permissions' => 'required',
                        ]
            );

            $input       = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)
            {
                $role->revokePermissionTo($p);
            }

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->route('roles.index')->with(
                'Role successfully updated.', 'Role ' . $role->name . ' updated!'
            );
        }else{
            return redirect()->back()->with('error','Permission denied.');
        }

    }


    public function destroy(Role $role)
    {   
        if(\Auth::user()->can('delete role')){
            $role->delete();
            return redirect()->route('roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        }else{
            return redirect()->back()->with('error','Permission denied.');
        }


    }
}
