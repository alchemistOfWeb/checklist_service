@extends('admin.layout')
@section('content')
    <h2>View one user</h2>
    <hr>

    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <span class="text-secondary">name: </span>Nikita Kuznetsov
        </li>
        <li class="list-group-item">
            <span class="text-secondary">email: </span>someemail@mail.com
        </li>
        <li class="list-group-item">
            <a class="link" href="{{route('checklists.index', 1)}}">
                checklists <span class="badge badge-info">12</span>
                <span class="sr-only">num of checklists</span>
            </a>
        </li>
        <li class="list-group-item">
            <span class="text-secondary">status: </span>active
        </li>
        
    </ul>
    
@endsection

