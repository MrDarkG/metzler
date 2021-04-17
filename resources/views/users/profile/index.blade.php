@extends('layouts.user')

@section("inlinecss")
    <style>
        canvas,.croppa-container{
            border-radius: 50%!important;
        }
    </style>
@endsection

@section('content')

<user-profile
	:user="{{ json_encode($user) }}"
></user-profile>
@endsection
