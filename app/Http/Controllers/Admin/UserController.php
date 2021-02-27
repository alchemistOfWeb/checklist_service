<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(15);
        
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->hasPermissionTo('create-users')) {
            abort(403, "You don't have permission to create users");
        }

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->hasPermissionTo('create-users') ) {
            abort(403, "You don't have permission to create users");
        }

        User::create($request->all());

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.users.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            abort(404, 'Such user does not exist');
        }

        return view('admin.users.edit', ['user' => $user]);
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
        $user = User::find($id);

        if (($request->name || $request->email)
            &&
            (!$admin->hasPermissionTo('edit-users'))) {
            
            abort(403, "You don't have permission to edit users");
        }

        if ($request->limit_of_checklists
            &&
            !$admin->hasPermissionTo('limiting-user-checklists')) {
            
            abort(403, "You don't have permission to limiting user checklists");
        }

        $request->validate([
            'name' => ['filled', 'between:4,64'],
            'email' => [
                'filled',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'limit-of-checklists' => ['filled']
        ]);

        $user->fill($request->all());
        
        if ($request->limit_of_checklists) {
            $user->limit_of_checklists = $request->limit_of_checklists;
        }
        
        $user->save();

        return redirect()->route('users.index');
    }

    public function toggleStatus($id) 
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin->hasPermissionTo('banning-users') ) {
            abort(403, "You don't have permission to banning users");
        }

        User::find($id)->toggleStatus();
        
        return redirect()->back();
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

        if (!$admin->hasPermissionTo('deleting-users') ) {
            abort(403, "You don't have permission to deleting users");
        }

        User::find($id)->delete();
        return redirect()->back();
    }
}
