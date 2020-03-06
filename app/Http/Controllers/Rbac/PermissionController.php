<?php

namespace App\Http\Controllers\Rbac;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\DB;
use Lang;
use Toastr;

class PermissionController extends Controller
{
    // Permission Listing Page
    public function index()
    {
        //
        $permissions = Permission::paginate(10);
        //dd($users);

        $params = [
            'title' => Lang::get('rbac.permission_list'),
            'permissions' => $permissions,
        ];

        return view('rbac.permission.perm_list')->with($params);
    }

    // Permission Create Page
    public function create()
    {
        //
        $params = [
            'title' => Lang::get('rbac.create_perm'),
        ];

        return view('rbac.permission.perm_create')->with($params);
    }

    // Permission Store to DB
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name' => 'required|unique:permissions',
            'display_name' => 'required',
            'description' => 'required',
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
            'display_name' => $request->input('display_name'),
            'description' => $request->input('description'),
        ]);
        Toastr::success(Lang::get('rbac.m_perm_suc_create', ['name' => $permission->name]), Lang::get('rbac.success'));
        return redirect()->route('permission.index');
    }

    // Permission Delete Confirmation Page
    public function show($id)
    {
        //
        try {
            $permission = Permission::findOrFail($id);

            $params = [
                'title' => Lang::get('rbac.delete_perm'),
                'permission' => $permission,
            ];

            return view('rbac.permission.perm_delete')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Permission Editing Page
    public function edit($id)
    {
        //
        try {
            $permission = Permission::findOrFail($id);

            $params = [
                'title' => Lang::get('rbac.edit_perm'),
                'permission' => $permission,
            ];

            //dd($role_permissions);

            return view('rbac.permission.perm_edit')->with($params);
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Permission update to DB
    public function update(Request $request, $id)
    {
        //
        try {
            $permission = Permission::findOrFail($id);

            $this->validate($request, [
                'display_name' => 'required',
                'description' => 'required',
            ]);

            $permission->name = $request->input('name');
            $permission->display_name = $request->input('display_name');
            $permission->description = $request->input('description');

            $permission->save();
            Toastr::success(Lang::get('rbac.m_perm_suc_update', ['name' => $permission->name]), Lang::get('rbac.success'));
            return redirect()->route('permission.index');
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }

    // Permission Delete from DB
    public function destroy($id)
    {
        //
        try {
            $permission = Permission::findOrFail($id);
            DB::table("permission_role")->where('permission_id', $id)->delete();
            $permission->delete();
            Toastr::success(Lang::get('rbac.m_perm_suc_delete', ['name' => $permission->name]), Lang::get('rbac.success'));
            return redirect()->route('permission.index');
        } catch (ModelNotFoundException $ex) {
            if ($ex instanceof ModelNotFoundException) {
                return response()->view('errors.' . '404');
            }
        }
    }
}