<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Role;

class UserRolesAdminController extends Controller
{
    public function index(){
        if(Auth::check()&&Auth::user()->isAdministrator()) {
            $userRoles =  User::query()
                ->leftJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
                ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
                ->select('users.id', 'users.name', 'users.email', 'roles.id as RoleID','roles.name as RoleName')->get();
            $users = array();
            foreach ($userRoles as $userRole){
                if(!isset($users[$userRole->id])) {
                    $users[$userRole->id] = array(
                        'name' => $userRole->name,
                        'email' => $userRole->email,
                        'roles' => array()
                    );
                    $users[$userRole->id]['roles'][$userRole->RoleID] = $userRole->RoleName;
                }else{
                    $users[$userRole->id]['roles'][$userRole->RoleID] = $userRole->RoleName;
                }

            }
            return view('UserRoles.index', compact('users'));
        }else{
            return redirect('home');
        }
    }

    public function show($user){
        if(Auth::check()&&Auth::user()->isAdministrator()) {
            $rolesList = Role::all();
            $roles = array();
            foreach ($rolesList as $roleItem){
                $roles[$roleItem->id] = array('name' => $roleItem->name, 'HasPriv' => false);
            }
            $userByID = User::find($user);
            if($userByID===null){ //if nothing found - go to list of all users
                return redirect('/admin');
            }
            $userRoles = $userByID->roles()->get();

            foreach ($userRoles as $userRole){
                $roles[$userRole->id]['HasPriv'] = true;
            }
            return view('UserRoles.show', compact('roles', 'userByID'));
        }else{
            return redirect('home');
        }
    }

    public function store($user){
        if(Auth::check()&&Auth::user()->isAdministrator()) {
            $rolesList = Role::all();
            $userByID = User::find($user);
            if($userByID===null){ //if nothing found - go to list of all users
                return redirect('/admin');
            }
            foreach ($rolesList as $role){
                $hasRole = $userByID->roles()->find($role->id);
                if(!$hasRole && (request('role_'.$role->id)==='on') ){
                    //Add role
                    $userByID->assignRole($role);
                }
                if($hasRole && !(request('role_'.$role->id)==='on')){
                    //Delete Role
                    $userByID->removeRole($role);
                }
                // All Ok
            }
            return redirect('/admin');
        }else{
            return redirect('home');
        }
    }
}
