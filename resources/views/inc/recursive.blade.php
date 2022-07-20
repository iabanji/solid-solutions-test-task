@foreach($leaves as $leave)
    <ul class="list-group" data-id="{{ $leave->id }}">
        <li class="list-group-item" data-id="{{ $leave->id }}">
            {{ $leave->title }}
            <button type="button" data-id="{{ $leave->id }}" id="btn-create-{{$leave->id}}" class="btn btn-primary" data-toggle="modal" data-target="#modal">+</button>
            <button type="button" data-id="{{ $leave->id }}" id="btn-delete-{{$leave->id}}" class="btn btn-primary" data-toggle="modal" data-target="#modal2">-</button>
            @if($leave->children()->count())
                @include('inc.recursive', ['leaves'=> $leave->children()->get()])
            @endif
        </li>
    </ul>
@endforeach
