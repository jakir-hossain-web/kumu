<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleManagerController extends Controller
{
    function role_create(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('admin.user.role_create',[
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }

    function role_assign(){
        $roles = Role::all();
        $users = User::all();
        return view('admin.user.role_assign',[
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }

    function permission_assign(){
        $permissions = Permission::all();
        $users = User::all();
        return view('admin.user.permission_assign',[
            'permissions'=>$permissions,
            'users'=>$users,
        ]);
    }

    function getPermission(Request $request) {
        $user = User::find($request->user_id);
        $user_all_permission = $user->getAllPermissions()->pluck('id')->toArray();
        $permissions_required = Permission::whereNotIn('id', $user_all_permission)->get();
        $str = '';
        foreach ($permissions_required as $permission) {
            $str .= "<div class='form-check'>
                        <input style='cursor: pointer' id='check{{$permission->id}}' class='form-check-input' value='$permission->id' type='checkbox' name='permission_id[]'>
                        <label style='cursor: pointer' class='form-check-label' for='check{{$permission->id}}'>
                        $permission->name
                    </div>";
                    
        }

        return response()->json([
            'html' => $str
        ]);
    }

    function permission_store(Request $request){
        $permission = Permission::create(['name' => $request->permission_name]);
        return back();
    }

    function role_store(Request $request){

        if($request->permission_id != ''){
           if($request->role_name != ''){
                if(Role::where('name', $request->role_name)->exists()){
                    return back()->with('role_name_duplicate','This Role Name is Already Used!'); 
                }
                else{
                    $role = Role::create(['name' => $request->role_name]);
                    $role->givePermissionTo($request->permission_id);
                   return back()->with('role_store_success','Role Created Successfully!');
                }
            } 
            else{
                return back()->with('role_name_empty','Role Name is Not Given!');
            }
        }
        else{
            return back()->with('role_permission_empty','Permissions are not selected!');
        }   
          
    }

    function role_delete($role_id){
        Role::where('id', $role_id)->delete();
        return back()->with('role_delete_success','Role Deleted Successfully!'); 
    }

    function role_edit($role_id){
        $permission_count = round(Permission::count()/4);
        $permissions_row_one = Permission::take($permission_count)->get();
        $permissions_row_two = Permission::skip($permission_count)->take($permission_count)->get();
        $permissions_row_three = Permission::skip($permission_count+$permission_count)->take($permission_count)->get();
        $permissions_row_four = Permission::skip($permission_count+$permission_count+$permission_count)->take($permission_count)->get();
        $role = Role::find($role_id); 
        return view('admin.user.role_edit',[
            'permissions_row_one'=>$permissions_row_one,
            'permissions_row_two'=>$permissions_row_two,
            'permissions_row_three'=>$permissions_row_three,
            'permissions_row_four'=>$permissions_row_four,
            'role'=>$role,
        ]);
    }

    function role_update(Request $request){

        $role = Role::find($request->role_id);

        if($request->permission_id != ''){
           if($request->role_name != ''){
                if(Role::where('id', $request->role_id)->where('name', $request->role_name)->exists()){
                    $role->syncPermissions($request->permission_id);
                    return back()->with('role_update_success','Role Updated Successfully!');
                }
                else{
                    if(Role::where('name', $request->role_name)->exists()){
                        return back()->with('role_name_duplicate','This Role Name is Already Used!'); 
                    }
                    else{
                        $role->syncPermissions($request->permission_id);
                        Role::where('id', $request->role_id)->update([
                            'name'=>$request->role_name,
                        ]);
                        return back()->with('role_update_success','Role Updated Successfully!');
                    }
                }
            } 
            else{
                $role->syncPermissions($request->permission_id);
                return back()->with('role_update_success','Role Updated Successfully!');
            }
        }
        else{
            return back()->with('role_permission_empty','Permissions are not selected!');
        }              
     }

    function user_role_assign(Request $request){
        if($request->user_id != null && $request->role_id != null){
            $user = User::find($request->user_id);
            $user_role = $user->getRoleNames();

            if(count($user_role) > 0){
                return back()->with('already_role_assign','This user role is already assigned!');
            }
            else{
                $user->assignRole($request->role_id);
                return back()->with('role_assign_success','Role Assigned Successfully!'); 
            }           
        }
        else{
            return back()->with('role_assign_empty','Select user & Role!');
        }
    }

    function user_permission_assign(Request $request){
        if($request->user_id != null && $request->permission_id != null){
            $user = User::find($request->user_id);
            $user->givePermissionTo($request->permission_id);
            return back()->with('permission_assign_success','Special Permission Assigned Successfully!'); 
        }
        else{
            return back()->with('permission_assign_empty','Select user & permission!');
        }
    }

    function user_role_edit($user_id){
        $user = User::find($user_id);
        $roles = Role::all();
        return view('admin.user.user_role_edit',[
            'user'=>$user,
            'roles'=>$roles,
        ]);
    }

    function user_permission_remove($user_id){
        $user = User::find($user_id);
        $user_all_permission = $user->getAllPermissions()->pluck('id')->toArray();
        $permissions_required = Permission::whereNotIn('id', $user_all_permission)->get();
        return view('admin.user.user_permission_edit',[
            'user'=>$user,
            'permissions_required'=>$permissions_required,
        ]);
    }

    function user_role_change(Request $request){
        $user = User::find($request->user_id);
        $user->syncRoles($request->role_id);
        return back()->with('user_role_change_success','User Role Changed Successfully!'); 
    }

    function user_role_delete($user_id){
        $user = User::find($user_id);
        $user->roles()->detach();
        return back()->with('user_role_remove_success','User Role Removed Successfully!'); 
    }

    function role_user_permission_remove(Request $request){
        $user = User::find($request->user_id);
        if($request->permission_id != ''){
            $user->revokePermissionTo($request->permission_id);
            return back()->with('user_permission_remove_success','Special Permission Removed Successfully!'); 
        }
        else{
            return back()->with('permission_not_selected','Permissions are not selected!');
        }
        
    }


}
