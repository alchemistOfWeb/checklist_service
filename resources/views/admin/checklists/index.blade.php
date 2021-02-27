@extends('admin.layout')
@section('content')
    <h2>{{$user->name}}'s checklists</h2>
    <hr>

    <div class="list-group">
        @foreach ($checklists as $checklist)
            <a href="
            {{
            route('checklists.show', ['user' => $user_id, 'checklist' => $checklist->id])
            }}" 
            class="list-group-item list-group-item-action flex-column align-items-start border rounded mb-2">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{$checklist->title}}</h5>
                    <small>{{$checklist->created_at}}</small>
                </div>
                <p class="mb-1">{{$checklist->description}}</p>
            </a>
            
        @endforeach
    </div>

    {{-- {{$checklists->links()}} --}}
    @include('includes.pagination', ['paginator' => $checklists])

@endsection