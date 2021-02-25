@extends('admin.layout-wrap')

@section('body')
    <div class="container-fluid d-flex align-items-center justify-content-center">
        <form action="{{route('admin.login')}}" method="POST" class="border p-3 rounded bg-dark text-light" style="width: 550px;">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                @error('email')
                    <span class="help-block text-danger mt-2">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                @error('password')
                    <span class="help-block text-danger mt-2">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                <label class="form-check-label" for="exampleCheck1">remember me</label>
            </div>

            <button type="submit" class="btn btn-info border mt-3">Login</button>

        </form>
        
    </div>
@endsection