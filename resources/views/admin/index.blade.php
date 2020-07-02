@extends('layouts.admin')

@section('navigation')
    {!! $navigation !!}
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8"><img style="margin-left: -3%" src="{{asset('/storage/uploads/laravel-1.png')}}"></div>
            <div class="col-2"></div>
        </div>
    </div>
@endsection
@section('footer')
    {!! $footer !!}
@endsection
