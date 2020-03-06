<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\DB;
use Lang;
use Toastr;

class RolesController extends Controller
{
    // Roles Listing Page
    public function index()
    {
        //
        $roles = Role::paginate(10);

        $params = [
            'title' => Lang::get('rbac.role_list_title'),
            'roles' => $roles,
        ];

        return view('rbac.roles.roles_list')->with($params);
    }

    // Roles Creation Page
    public function create()
    {
        //
        $permissions = Permission::all();

        $params = [
            'title' => Lang::get('rbac.b_create_role'),
            'permissions' => $permissions,
        ];

        return view('rbac.roles.roles_create')->with($params);
    }

    // Roles Store to DB
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:roles',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description' => $request->input('description'),
        ]);
        Toastr::success(Lang::get('rbac.m_role_suc_create', ['name' => $role->name]), Lang::get('rbac.success'));
        return redirect()->route('roles.index');
    }

    // Roles Delete Confirmation Page
    public function show($id)
    {
        //
        try {
            $role = Role::findOrFail($id);

            $params = [
                'title' => Lang::get('rbac.delete_role'),
                'role' => $role,
            ];

            return view('rbac.roles.roles_delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Roles Editing Page
    public function edit($id)
    {
        //
        try {
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            $role_permissions = $role->permissions()->get()->pluck('id')->toArray();

            $params = [
                'title' => Lang::get('rbac.edit_role'),
                'role' => $role,
                'permissions' => $permissions,
                'role_permissions' => $role_permissions,
            ];

            return view('rbac.roles.roles_edit')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Roles Update to DB
    public function update(Request $request, $id)
    {
        //
        try {
            $role = Role::findOrFail($id);

            $this->validate($request, [
                'display_name' => 'required',
                'description' => 'required',
            ]);

            $role->name = $request->input('name');
            $role->display_name = $request->input('display_name');
            $role->description = $request->input('description');

            $role->save();

            DB::table("permission_role")->where("permission_role.role_id", $id)->delete();
            // Attach permission to role
            foreach ($request->input('permission_id') as $key => $value) {
                $role->attachPermission($value);
            }
            Toastr::success(Lang::get('rbac.m_role_suc_update', ['name' => $role->name]), Lang::get('rbac.success'));
            return redirect()->route('roles.index');
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Delete Roles from DB
    public function destroy($id)
    {
        //
        try {
            $role = Role::findOrFail($id);

            //$role->delete();

            // Force Delete
            $role->users()->sync([]); // Delete relationship data
            $role->permissions()->sync([]); // Delete relationship data

            $role->forceDelete(); // Now force delete will work regardless of whether the pivot table has cascading delete
            Toastr::success(Lang::get('rbac.m_role_suc_delete', ['name' => $role->name]), Lang::get('rbac.success'));
            return redirect()->route('roles.index');
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }
}