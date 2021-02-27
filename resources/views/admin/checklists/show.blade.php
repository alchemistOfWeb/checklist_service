@extends('admin.layout')
@section('content')
    <ul class="list-group m-3 p-3">
        <li class="list-group-item active">
            <h4 class="mb-1">{{$checklist->title}}</h4>
            <p>
                {{$checklist->description}}
            </p>
        </li>
        @foreach ($checklist->options as $item)
            <li class="list-group-item d-flex justify-content-between list-group-item-info">
                <span>{{$item['title']}}</span>

                <div class="form-check">
                    <input 
                    class="form-check-input position-static input-disabled-style" 
                    type="checkbox"  
                    value="" 
                    name="" 
                    @if($item['is_done'])
                    checked
                    @endif
                    disabled>
                </div>
            </li>
        @endforeach
    </ul>

@endsection