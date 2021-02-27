@extends('admin.layout')
@section('content')
    <h2>Edit role</h2>
    <hr>
    
    @include('includes.errors')

    <form 
    class="px-0 py-3 col-xl-4 col-md-5 col-lg-6" 
    action="{{route('roles.update', $role->id)}}"
    method="POST"
    >
        @method('put')
        @csrf

        <div class="form-group">
            <label for="role-name">Name:</label>
            <input 
            type="text" 
            class="form-control" 
            id="role-name" 
            name="name"
            value="{{$role->name}}"
            aria-describedby="nameHelp" 
            placeholder="Enter name"
            required
            @nopermission('edit-roles')
                disabled
            @endpermission
            >
            <small id="nameHelp" class="form-text text-muted">It can consist of several words</small>
        </div>

        <div class="form-group">
            <div class="d-flex flex-wrap" id="permission-list">  

                {{-- Here is the place for permission blocks --}}
                @foreach ($role->permissions as $permission)

                    <h4 class="m-1 attaching-block">
                        <span 
                        class="badge badge-pill 
                        @haspermission('edit-roles')
                        badge-primary
                        @elsepermission
                        badge-secondary
                        @endpermission
                        ">
                            <span class="selected-option-name">{{$permission->name}}</span>
                            <span 
                            aria-hidden="true" 
                            class="rounded-circle bg-light text-dark px-1 ml-2 detach-option-btn" 
                            @haspermission('edit-roles')
                                style="cursor: pointer;"
                                onclick="fnDetachOption($(this), 'select-permissions')"
                            @endpermission

                            >&times;</span>
                        </span>
                        <input type="text" name="permissions[]" value="{{$permission->id}}" class="attaching-option-hidden" hidden>
                    </h4>

                @endforeach

            </div>
            <label class="my-1 mr-2" for="select-permissions">Permissions:</label>
            <select 
            class="custom-select my-1 mr-sm-2" 
            id="select-permissions"
            @nopermission('edit-roles')
                disabled
            @endpermission
            >
                <option value="0" selected>Choose permissions for this role...</option>
                @foreach ($permissions as $permission)
                    <option 
                    value="{{$permission->id}}"
                    >{{$permission->name}}</option>
                    
                @endforeach
            </select>
        </div>
        
        <button 
        type="submit" 
        class="btn btn-success my-3"
        @nopermission('edit-roles')
            disabled
        @endpermission
        >
            Save
        </button>
    </form>


    <script type="text/javascript">
        $permissionList = $('#permission-list');
        $selectPermissionsElement = $('#select-permissions');

        $selectPermissionsElement.change(function(){
            fnAttachOption($(this), $permissionList, 'permissions');
        });

    </script>

@endsection