<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::paginate(15);

        return view('admin.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorizeForUser(auth('admin')->user(), 'create', Admin::class);

        $roles = Role::all();
        
        return view('admin.admins.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorizeForUser(auth('admin')->user(), 'create', Admin::class);

        $request->validate([
            'name' => 'required|between:4,64',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|confirmed|string|between:4,255',
        ]);

        Admin::create($request->all());

        return redirect()->route('admins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::find($id);

        return view('admin.admins.show', ['admin' => $admin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorizeForUser(auth('admin')->user(), 'update', Admin::class);

        $admin = Admin::find($id);

        $ids = $admin->roles->map(function($el){
            return $el->id;
        });

        $roles = Role::whereNotIn('id', $ids)->get();
        
        return view('admin.admins.edit', [
            'admin' => $admin,
            'roles' => $roles,
            ]
        );
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
        $admin = Admin::find($id);

        $request->validate([
            'roles' =>'array',
            'roles.*' =>'exists:roles,id',
            'name' => [
                'filled', 
                'between:4,64',
            ],
            'email' => [
                'filled',
                'email',
                Rule::unique('admins', 'email')->ignore($admin->id),
            ],
        ]);

        $admin_current = auth('admin')->user();

        if ( isset($request['name']) || isset($request['email']) ) {
            $this->authorizeForUser($admin_current, 'edit', $admin);
        }

        if ( isset($request['special']) ) {
            $this->authorizeForUser($admin_current, 'manage-roles', $admin);

            $this->adminService->handleUpdatingRoles($request, $admin);
        }
        
        $admin->edit($request->only('name', 'email'));

        return redirect()->route('admins.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorizeForUser(auth('admin')->user(), 'delete', Admin::find($id));

        Admin::find($id)->delete();

        return redirect()->route('admins.index');
    }
}