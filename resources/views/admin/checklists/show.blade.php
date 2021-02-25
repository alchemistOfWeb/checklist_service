@extends('admin.layout')
@section('content')
    <ul class="list-group mb-3">
        <li class="list-group-item active">
            <h4 class="mb-1">{{$checklist->title}}</h4>
            <p>
                {{$checklist->description}}
            </p>
        </li>
        @foreach (json_decode($checklist->options) as $item)
            <li class="list-group-item d-flex justify-content-between list-group-item-info">
                <span>{{$item->title}}</span>

                <div class="form-check">
                    <input 
                    class="form-check-input position-static input-disabled-style" 
                    type="checkbox"  
                    value="" 
                    name="" 
                    @if($item->is_done)
                    checked
                    @endif
                    disabled>
                </div>
            </li>
        @endforeach
    </ul>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Prev</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
@endsection