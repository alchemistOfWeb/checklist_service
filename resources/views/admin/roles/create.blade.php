@extends('admin.layout')
@section('content')
    <h2>Create role</h2>
    <hr>
    
    @include('includes.errors')

    <form 
    class="px-0 py-3 col-xl-4 col-md-5 col-lg-6" 
    action="{{route('roles.store')}}"
    method="POST">
        @csrf
        <div class="form-group">
            <label for="role-name">Name:</label>
            <input 
            type="text" 
            class="form-control" 
            id="role-name" 
            name="name"
            value="{{old('name')}}"
            aria-describedby="nameHelp" 
            placeholder="Enter name"
            required
            >
            <small id="nameHelp" class="form-text text-muted">It can consist of several words</small>
        </div>

        <div class="form-group">
            <div class="d-flex flex-wrap" id="permission-list">  
                {{-- Here is the place for permission blocks --}}
            </div>
            <label class="my-1 mr-2" for="select-permissions">Permissions:</label>
            <select class="custom-select my-1 mr-sm-2" id="select-permissions">
                <option value="0" selected>Choose permissions for this role...</option>
                @foreach ($permissions as $permission)
                    <option 
                    value="{{$permission->id}}"
                    >{{$permission->name}}</option>
                    
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-success my-3">Create</button>
    </form>


    <script type="text/javascript">
        $permissionList = $('#permission-list');
        $selectPermissionsElement = $('#select-permissions');
        
        $selectPermissionsElement.change(function(){
            fnAttachOption($(this), $permissionList, 'permissions');
        });
    </script>

@endsection



{{-- ALTERNATIVE MARKUP FOR SELECTED PERMISSIONS --}}
{{-- <h4 class="m-1">
    <span class="badge badge-pill badge-primary">
        sething
    </span>
    <div class="badge badge-danger badge-pill rounded-circle close m-1 p-0" aria-label="Close" style="width:25px; height:25px; cursor: pointer;">
        <span aria-hidden="true">&times;</span>
    </div>
</h4> --}}