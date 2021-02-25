@extends('admin.layout')
@section('content')
    <h2>users</h2>
    <hr>
    
    <a href="{{route('users.create')}}" class="btn btn-success border">create user</a>

    <table class="table table-striped table-inverse table-responsive py-4 table-hover">
        <tfoot>
            <tr>
                <td colspan="5">
                    @include('includes.pagination', ['paginator' => $users])
                </td>
            </tr>
        </tfoot>
        <thead class="thead-inverse">
            <tr>
                <th>№</th>
                <th>name</th>
                <th>email</th>
                <th>limit of checklists</th>
                <th>status</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($users as $user)
                <tr>
                    <td scope="row">{{$loop->iteration}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->limit_of_checklists}}</td>
                    <td>
                        @if ($user->isBanned())
                            <span class="text-danger">banned</span>
                        @else
                            <span class="text-success">active</span>
                        @endif
                    </td>
                    
                    <td class="bg-light" style="border-top: 0px;" data-toggle="tooltip" data-placement="top" title="delete user">
                        <form action="{{route('users.destroy', $user->id)}}" method="post">
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

                    <td class="bg-light" style="border-top: 0px;" data-toggle="tooltip" data-placement="top" title="edit user">
                        <a class="close edit text-primary" 
                        href="{{route('users.edit', $user->id) }}" 
                        aria-label="Close">
                            <span aria-hidden="true">&#9998;</span>
                        </a>
                    </td>

                    <td class="bg-light" style="border-top: 0px;">
                        <a class="" href="{{route('checklists.index', $user->id)}}">
                            checklists 
                            <span class="badge badge-info">
                                {{$user->num_of_checklists}}
                            </span>
                            <span class="sr-only">num of checklists</span>
                        </a>
                    </td>

                    <td class="bg-light" style="border-top: 0px;">
                        <form action="{{route('users.toggleStatus', $user->id)}}" method="post">
                            @method('patch')
                            @csrf   
                            <button 
                            type="submit" 
                            class="btn btn-primary btn-sm"
                            >
                            @if($user->is_banned)
                                unban
                            @else
                                ban
                            @endif

                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

@endsection
