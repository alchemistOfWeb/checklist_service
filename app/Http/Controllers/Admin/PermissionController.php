<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::paginate(15);

        return view('admin.permissions.index', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->hasPermissionTo('edit-permissions') ) {
            abort(403, "You don't have permission to edit permissions");
        }

        $request->validate([
            'name' => 'required|string|between:3,255'
        ]);
        
        Permission::create($request->all());

        return redirect()->route('permissions.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->hasPermissionTo('edit-permissions') ) {
            abort(403, "You don't have permission to edit permissions");
        }

        $request->validate([
            'name' => 'required|string|between:3,255',
            'permissions' =>'array',
        ]);

        Permission::find($id)->edit($request->all());

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->hasPermissionTo('edit-permissions') ) {
            abort(403, "You don't have permission to edit permissions");
        }

        Permission::find($id)->delete();

        return redirect()->route('permissions.index');
    }
}
