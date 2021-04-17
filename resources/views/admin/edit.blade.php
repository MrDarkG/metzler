@extends('layouts.user')

@section("inlinecss")
    <style>
        canvas,.croppa-container{
            border-radius: 50%!important;
        }
    </style>
@endsection
@section('content')
    
    <admin-user-edit :user="{{ json_encode($user) }}"></admin-user-edit>
@endsection


