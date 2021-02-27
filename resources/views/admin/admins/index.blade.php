@extends('admin.layout')

@section('content')
    <h2>admins</h2>
    <hr>
    
    <a 
    href="{{route('admins.create')}}" 
    class="btn btn-success border
    @nopermission('create-admins')
        disabled
    @endpermission
    "
    >create admin</a>

    <table class="table table-striped table-inverse table-responsive py-4 table-hover">
        <tfoot>
            <tr>
                <td colspan="4">
                    {{-- @include('includes.pagination', ['paginator' => $admins]) --}}
                    {{$admins->links()}}
                </td>
            </tr>
        </tfoot>

        <thead class="thead-inverse">
            <tr>
                <th>№</th>
                <th>name</th>
                <th>email</th>
                <th>roles</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($admins as $admin)
                <tr>
                    <td scope="row">
                        {{$loop->iteration + (($admins->currentPage() - 1) * $admins->perPage())}}
                    </td>
                    <td>{{$admin->name}}</td>
                    <td>{{$admin->email}}</td>
                    <td>
                        {{$admin->roles->implode('name', ', ')}}
                    </td>
                    <td class="bg-light" style="border-top: 0px;">
                        <form action="{{route('admins.destroy', $admin->id)}}" method="post">
                            @method('delete')
                            @csrf
                            <button 
                            type="submit" 
                            @haspermission('deleting-users')
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
                        class="close edit 
                        @haspermission('edit-admins')
                            text-primary
                        @elsepermission 
                            text-secondary disabled 
                        @endpermission
                        " 
                        href="{{route('admins.edit', $admin->id)}}" 
                        aria-label="Close">
                            <span aria-hidden="true">&#9998;</span>
                        </a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>


@endsection