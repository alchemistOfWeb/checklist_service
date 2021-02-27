@extends('admin.layout')

@section('content')
    <h2>permissions</h2>
    <hr>

    @include('includes.errors')

    <form class="form-inline" action="{{route('permissions.store')}}" method="post">
        @csrf
        <div class="form-group mr-sm-3 mb-2">
            <input 
            type="text" 
            class="form-control"
            name="name"
            id="addPermission" 
            placeholder="permission name"
            @nopermission('edit-permissions')
                disabled
            @endpermission
            >
        </div>

        <button 
        type="submit" 
        class="btn btn-success border mb-2" 
        @nopermission('edit-permissions')
            disabled
        @endpermission
        >
            create permission
        </button>
    </form>
    
    <table class="table table-striped table-inverse table-responsive py-4 table-hover">
        <tfoot>
            <tr>
                <td colspan="4">
                    {{-- @include('includes.pagination', ['paginator' => $permissions]) --}}
                    {{$permissions->links()}}
                </td>
            </tr>
        </tfoot>

        <thead class="thead-inverse">
            <tr>
                <th>№</th>
                <th>id</th>
                <th>slug</th>
                <th>name</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$permission->id}}</td>
                    <td class="form-control-sm">{{$permission->slug}}</td>
                    <td>
                        <div class="form-group" style="margin: 0 !important;">
                            <input 
                            type="text" 
                            readonly    
                            class="form-control-sm form-control-plaintext" 
                            id="permission-name-{{$permission->id}}"
                            name="name"
                            value="{{$permission->name}}" 
                            form="permission-form-{{$permission->id}}"
                            >
                        </div>
                        
                    </td>
                    <td class="bg-light" style="border-top: 0px;">
                        <form action="{{route('permissions.destroy', $permission->id)}}" method="post">
                            @method('delete')
                            @csrf
                            <button 
                            type="submit" 
                            @haspermission('edit-permissions')
                                class="close text-danger"
                            @elsepermission
                                class="close text-secondary"
                                disabled
                            @endpermission
                            aria-label="Close"
                            onclick="return confirm('are you sure?')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </form>
                    </td>
                    <td class="bg-light" style="border-top: 0px;">
                        <a 
                        aria-label="Close"
                        @haspermission('edit-permissions')
                            class="close edit text-primary" 
                            style="cursor: pointer;"
                            onclick="
                                $permissionForm = $('#permission-form-{{$permission->id}}');
                                $permissionName = $('#permission-name-{{$permission->id}}');
                                $permissionName.toggleClass('form-control-plaintext');
                                $permissionName.toggleClass('form-control');

                                if ($permissionForm.attr('hidden')) {
                                    $permissionForm.attr('hidden', false);
                                    $permissionName.attr('readonly', false);
                                } else {
                                    $permissionForm.attr('hidden', true);
                                    $permissionName.attr('readonly', true);
                                }
                            "
                        @elsepermission
                            class="close edit text-secondary"
                            disabled
                        @endpermission
                        >
                            <span aria-hidden="true">&#9998;</span>
                        </a>
                    </td>
                    <td class="bg-light" style="border-top: 0px;">
                        <form 
                        id="permission-form-{{$permission->id}}" 
                        action="{{route('permissions.update', $permission->id)}}" 
                        method="post"
                        hidden
                        >
                            @method('put')
                            @csrf
                            <button type="submit" class="btn btn-success border">save</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
        
    </table>


@endsection