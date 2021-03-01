<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Policies\RolePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(15);

        return view('admin.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorizeForUser(auth('admin')->user(), 'manage', Role::class);

        $permissions = Permission::all();

        return view('admin.roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorizeForUser(auth('admin')->user(), 'manage', Role::class);

        $request->validate([
            'name' => 'required|string|between:3,255',
            'permissions' =>'array|exists:permissions,id',
        ]);
        
        Role::create($request->all());

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorizeForUser(auth('admin')->user(), 'manage', Role::class);

        $role = Role::find($id);

        $ids = $role->permissions->map(function($el){
            return $el->id;
        });

        $permissions = Permission::whereNotIn('id', $ids)->get();
        
        return view('admin.roles.edit', [
            'permissions'   => $permissions,
            'role'          => $role
        ]);
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
        $this->authorizeForUser(auth('admin')->user(), 'manage', Role::class);
        
        $request->validate([
            'name' => 'required|string|between:3,255',
            'permissions' =>'array',
            'permissions.*' =>'exists:permissions,id',
        ]);

        Role::find($id)->edit($request->all());

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorizeForUser(auth('admin')->user(), 'manage', Role::class);
        
        Role::find($id)->delete();
        
        return redirect()->route('roles.index');
    }
}
