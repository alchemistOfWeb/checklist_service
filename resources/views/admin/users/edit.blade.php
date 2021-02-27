@extends('admin.layout')
@section('content')
    <h2>Edit {{$user->name}} user</h2>
    <hr>

    <form class="px-0 py-3 col-xl-4 col-md-5 col-lg-6" action="{{route('users.update', $user->id)}}" method="POST">
        @method('put')
        @csrf


        <div class="form-group">
            <label for="user-limit-of-checklists">Limit of checklists</label>
            <input 
            type="number" 
            class="form-control" 
            id="user-limit-of-checklists" 
            name="limit_of_checklists"
            aria-describedby="limit-of-checklistsHelp" 
            placeholder="Enter limit of checklists"
            value="{{$user->limit_of_checklists}}"
            @nopermission('limiting-user-checklists')
                disabled
            @endpermission
            >
            <small id="limit-of-checklistsHelp" class="form-text text-muted">
                now user has {{$user->num_of_checklists}} checklists
            </small>
        </div>

        <div class="form-group">
            <label for="user-name">Name</label>
            <input 
            type="text" 
            class="form-control" 
            id="user-name" 
            name="name"
            value="{{$user->name}}"
            aria-describedby="nameHelp" 
            placeholder="Enter name"
            @nopermission('edit-users')
                disabled
            @endpermission
            >
            <small id="nameHelp" class="form-text text-muted">enter min 6 letters</small>
        </div>

        <div class="form-group">
            <label for="user-email">Email address</label>
            <input 
            type="email" 
            class="form-control" 
            id="user-email" 
            name="email"
            value="{{$user->email}}"
            aria-describedby="emailHelp" 
            placeholder="Enter email"
            @nopermission('edit-users')
                disabled
            @endpermission
            >
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>

        <button type="submit" class="btn btn-success my-3"
        @nopermission('edit-users', 'limiting-user-checklists')
            disabled
        @endpermission
        >save</button>
    </form>
@endsection