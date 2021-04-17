@extends('layouts.user')

@section('content')
<edit-post
	:old_post="{{ json_encode($post) }}"
></edit-post>

@endsection
