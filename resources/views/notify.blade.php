@extends('layouts.app', [
'class' => '',
'elementActive' => 'dashboard'
])

@section('content') 
    @foreach ($subscriptions as $sub)
        <form action="/admin/sendNotif/{{$sub->id}}" method="POST">
            Sub #{{$sub->id}}
            <input class="py-1 my-2" type="text" name="title" placeholder="title">
            <input class="py-1 my-2" type="text" name="body" placeholder="body">
            <input class="py-1 my-2" type="text" name="desc" placeholder="desc">
            <input class="py-1 my-2" type="text" name="loc" placeholder="loc">
            <input class="py-1 my-2" type="text" name="url" placeholder="url">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="btn btn-primary my-2" type="submit" value="Send">
        </form>
    @endforeach
@endsection