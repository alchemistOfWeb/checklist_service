@extends('admin.layout')

@section('content')
    <h2>permissions</h2>
    <hr>

    @include('includes.errors')
    
    <table class="table table-striped table-inverse table-responsive py-4 table-hover">
        <tfoot>
            <tr>
                <td colspan="4">
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
                    <td>{{$permission->slug}}</td>
                    <td>{{$permission->name}}</td>
                </tr>
            @endforeach

        </tbody>
        
    </table>


@endsection