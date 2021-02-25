@extends('admin.layout')
@section('content')
    <h2>edit {{$admin->name}} admin</h2>
    <hr>

    @include('includes.errors')
 

    <form 
    class="px-0 py-3 col-xl-4 col-md-5 col-lg-6" 
    action="{{route('admins.update', $admin->id)}}"
    method="POST">
        @method('put')
        @csrf
        <div class="form-group">
            <label class="my-1 mr-2" for="select-roles">Roles:</label>
            <div class="d-flex flex-wrap" id="role-list">  
                @foreach ($admin->roles as $role)

                    <h4 class="m-1 attaching-block">
                        <span class="badge badge-pill badge-primary">
                            <span class="selected-option-name">{{$role->name}}</span>
                            <span 
                            class="rounded-circle bg-light text-dark px-1 ml-2 detach-option-btn" aria-hidden="true" 
                            style="cursor: pointer;"
                            onclick="fnDetachOption($(this), 'select-roles')"
                            >&times;</span>
                        </span>
                        <input type="text" name="roles[]" value="{{$role->id}}" class="attaching-option-hidden" hidden>
                    </h4>

                @endforeach
            </div>
            
            <select class="custom-select my-1 mr-sm-2" id="select-roles">
                <option value="0" selected>Choose role for admin...</option>
                @foreach ($roles as $role)
                    <option 
                    value="{{$role->id}}"
                    >{{$role->name}}</option>
                    
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="admin-name">Name</label>
            <input 
            type="text" 
            class="form-control" 
            id="admin-name" 
            name="name"
            value="{{$admin->name}}"
            aria-describedby="nameHelp" 
            placeholder="Enter name">
            <small id="nameHelp" class="form-text text-muted">enter min 6 letters</small>
        </div>

        <div class="form-group">
            <label for="admin-email">Email address</label>
            <input 
            type="email" 
            class="form-control" 
            id="admin-email" 
            name="email"
            value="{{$admin->email}}"
            aria-describedby="emailHelp" 
            placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>

        <button type="submit" class="btn btn-success my-3">Save</button>
    </form>

    <script type="text/javascript">
        $roleList = $('#role-list');
        $selectRolesElement = $('#select-roles');
        
        $selectRolesElement.change(function(){
            fnAttachOption($(this), $roleList, 'roles');
        });
    </script>

@endsection