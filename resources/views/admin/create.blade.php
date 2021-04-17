@extends('layouts.user')

@section("inlinecss")
    <style>
        canvas,.croppa-container{
            border-radius: 50%!important;
        }
    </style>
@endsection
@section('content')
    
    <admin-user-create></admin-user-create>
@endsection


