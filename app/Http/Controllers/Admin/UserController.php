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
        $this->authorizeForUser(auth('admin')->user(), 'create', User::class);

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
        $this->authorizeForUser(auth('admin')->user(), 'create', User::class);

        User::create($request->all());

        return redirect()->route('users.index');
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
        $admin = auth('admin')->user();

        if (($request->name || $request->email)) {
            $this->authorizeForUser($admin, 'edit', User::class);
        }

        if ($request->limit_of_checklists) {
            $this->authorizeForUser($admin, 'limit-checklists', User::class);
        }

        $user = User::find($id);

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
        $this->authorizeForUser(auth('admin')->user(), 'ban', User::class);

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
        $this->authorizeForUser(auth('admin')->user(), 'delete', User::class);

        User::find($id)->delete();

        return redirect()->back();
    }
}

// if ( !Gate::allows('edit-roles')) {
//     dd('hello');
// }