@extends('admin.layout-wrap')

@section('body')
    
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{route('dashboard.index')}}" data-toggle="tooltip" data-placement="right" title="to the dashboard page">Admin panel </a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarCollapse"
            aria-controls="navbarCollapse"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto sidenav" id="navAccordion">
                <li class="nav-item">
                    <ul class="list-group p-2">
                        <li class="text-light">
                            <span >@admin_name</span>
                        </li>
                        <li class="">
                            <span class="text-light">@admin_email</span>
                        </li>
                        <li class="">
                            <span class="text-light">@admin_roles</span>
                        </li>
                    </ul>
                    {{-- <a class="nav-link" href="#"> </a> --}}
                    <hr class="bg-warning m-2">
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admins.index')}}">
                        <span class="nav-link-text">Admins</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.index')}}">
                        <span class="nav-link-text">Users</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{route('roles.index')}}">
                        <span class="nav-link-text">Roles</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route('permissions.index')}}">
                        <span class="nav-link-text">Permissions</span>
                    </a>
                </li>
                
            </ul>
            <div class="ml-auto mt-2 mt-md-0">
                <a href="{{route('admin.logout')}}" class="h3 link-logout" onclick="return confirm('Do you really want to logout???')">logout</a>
            </div>
        </div>
    </nav>
        
    <main class="content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>
        
    <footer class="footer">
        <div class="container">
            <div class="text-center">
                <span>Coded by 
                    <a href="https://github.com/alchemistOfWeb">alchemistOfWeb</a>, 2021
                </span>
            </div>
        </div>
    </footer>





    <script type="text/javascript">
        $(document).ready(function() {
            $('.nav-link-collapse').on('click', function() {
                $('.nav-link-collapse').not(this).removeClass('nav-link-show');
                $(this).toggleClass('nav-link-show');
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endsection
    

