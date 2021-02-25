@extends('admin.layout')

@section('content')
    <h2>Roles</h2>
    <hr>

    <a href="{{route('roles.create')}}" class="btn btn-success border mr-sm-3">create role</a>
    <a href="{{route('permissions.index')}}" class="btn btn-primary border">Permissions</a>
    <table class="table table-striped table-inverse table-responsive py-4 table-hover">

        <tfoot>
            <tr>
                <td colspan="4">
                    @include('includes.pagination', ['paginator' => $roles])
                </td>
            </tr>
        </tfoot>

        <thead class="thead-inverse">
            <tr>
                <th>№</th>
                <th>id</th>
                <th>name</th>
                <th>slug</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->slug}}</td>
                    <td class="bg-light" style="border-top: 0px;">
                        <form action="{{route('roles.destroy', $role->id)}}" method="post">
                            @method('delete')
                            @csrf
                            <button 
                            type="submit" 
                            class="close text-danger" 
                            aria-label="Close"
                            onclick="return confirm('are you sure?')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </form>
                    </td>
                    <td class="bg-light" style="border-top: 0px;">
                        <a class="close edit text-primary" 
                        href="{{route('roles.edit', $role->id)}}" 
                        aria-label="Close">
                            <span aria-hidden="true">&#9998;</span>
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>


@endsection