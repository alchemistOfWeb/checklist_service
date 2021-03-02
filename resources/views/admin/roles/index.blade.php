@extends('admin.layout')

@section('content')
    <h2>Roles</h2>
    <hr>

    <a 
    href="{{route('roles.create')}}" 
    class="btn btn-success border mr-sm-3
    @nopermission('edit-roles')
    disabled
    @endpermission
    "
    >create role</a>
    <a href="{{route('permissions.index')}}" class="btn btn-primary border">Permissions</a>
    <table class="table table-striped table-inverse table-responsive py-4 table-hover">

        <tfoot>
            <tr>
                <td colspan="5">
                    {{$roles->links()}}
                </td>
            </tr>
        </tfoot>

        <thead class="thead-inverse">
            <tr>
                <th>№</th>
                <th>id</th>
                <th>name</th>
                <th>slug</th>
                <th>permissions</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->slug}}</td>
                    <td>{{$role->permissions->implode('name', ', ')}}</td>

                    <td class="bg-light" style="border-top: 0px;">
                        <form action="{{route('roles.destroy', $role->id)}}" method="post">
                            @method('delete')
                            @csrf
                            <button 
                            type="submit" 
                            aria-label="Close"
                            @haspermission('edit-roles')
                                onclick="return confirm('are you sure?')"
                                class="close text-danger" 
                            @elsepermission
                                class="close text-secondary" 
                                disabled
                            @endpermission
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </form>
                    </td>
                    <td class="bg-light" style="border-top: 0px;">
                        <a 
                        href="{{route('roles.edit', $role->id)}}" 
                        aria-label="Close"
                        @haspermission('edit-roles') 
                            class="close edit text-primary"
                        @elsepermission
                            class="close edit disabled text-secondary"
                        @endpermission
                        >
                            <span aria-hidden="true">&#9998;</span>
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>


@endsection