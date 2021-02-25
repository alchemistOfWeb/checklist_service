@extends('admin.layout')
@section('content')
    <h2>Create user</h2>
    <hr>

    @include('includes.errors')

    <form 
    class="px-0 py-3 col-xl-4 col-md-5 col-lg-6" 
    action="{{route('users.store')}}" 
    method="POST">
        @csrf

        <div class="form-group">
            <label for="user-name">Name</label>
            <input 
            type="text" 
            class="form-control" 
            id="user-name" 
            name="name"
            value="{{old('name')}}"
            aria-describedby="nameHelp" 
            placeholder="Enter name">
            <small id="nameHelp" class="form-text text-muted">enter min 6 letters</small>
        </div>

        <div class="form-group">
            <label for="user-email">Email address</label>
            <input 
            type="email" 
            class="form-control" 
            id="user-email" 
            name="email"
            value="{{old('email')}}"
            aria-describedby="emailHelp" 
            placeholder="Enter email">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>

        <div class="form-group">
            <label for="user-password">Password</label>
            <input 
            type="password" 
            class="form-control" 
            id="user-password" 
            name="password"
            placeholder="Password">
        </div>

        <div class="form-group">
            <label for="user-password-confirmation">Confirm password</label>
            <input 
            type="password" 
            class="form-control" 
            id="user-password-confirmation" 
            name="password_confirmation"
            placeholder="Password confirmation">
        </div>

        <button type="submit" class="btn btn-success my-3">Create</button>
    </form>
@endsection