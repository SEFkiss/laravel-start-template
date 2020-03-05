<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Permission;
use Lang;

class UsersController extends Controller
{
    //

    public function __construct()
    {
        //$this->middleware('role:users');
    }

    // Index Page for Users
    public function index()
    {
        $users = User::paginate(10);
        
        $params = [
            'title' => Lang::get('rbac.user_list_title'),
            'users' => $users,
        ];
//var_dump($users->toArray());die;
        return view('rbac.users.users_list')->with($params);
    }

    // Create User Page
    public function create()
    {
        $roles = Role::all();

        $params = [
            'title' => Lang::get('rbac.create_user_title'),
            'roles' => $roles,
        ];

        return view('rbac.users.users_create')->with($params);
    }

    // Store New User
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $role = Role::find($request->input('role_id'));

        $user->attachRole($role);

        return redirect()->route('users.index')->with('success', Lang::get('rbac.user_success_create', ['name' => $user->name]));
    }

    // Delete Confirmation Page
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            $params = [
                'title' => Lang::get('rbac.user_delete_title'),
                'user' => $user,
            ];

            return view('rbac.users.users_delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Editing User Information Page
    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);

            //$roles = Role::all();
            $roles = Role::with('permissions')->get();
            //var_dump($roles->toArray());die;
            $permissions = Permission::all();

            $params = [
                'title' => Lang::get('rbac.edit_user_title'),
                'user' => $user,
                //'roles' => $roles,
                'permissions' => $permissions,
            ];

            return view('rbac.users.users_edit', compact('roles'))->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Update User Information to DB
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $id,
            ]);

            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $user->save();

            // Update role of the user
            $roles = $user->roles;

            foreach ($roles as $key => $value) {
                $user->detachRole($value);
            }

            $role = Role::find($request->input('role_id'));

            $user->attachRole($role);

            // Update permission of the user
            //$permission = Permission::find($request->input('permission_id'));
            //$user->attachPermission($permission);

            return redirect()->route('users.index')->with('success', Lang::get('rbac.user_success_update', ['name' => $user->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Remove User from DB with detaching Role
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Detach from Role
            $roles = $user->roles;

            foreach ($roles as $key => $value) {
                $user->detachRole($value);
            }

            $user->delete();

            return redirect()->route('users.index')->with('success', Lang::get('rbac.user_success_delete', ['name' => $user->name]));
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }
}
