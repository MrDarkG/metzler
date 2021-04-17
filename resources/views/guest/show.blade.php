@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="d-flex flex-column costum-card ">
        <div>
            <span class="post-title">{{ $post->title }} </span> <br>
            <span class="post-date">{{ $post->created_at }}</span>
        </div>
        <div>
            <img src="{{ $post->picture }}" class="rounded mr-3" align="left">
            {{ $post->content }}
        </div>
        <div class="d-flex mt-4">
            <div class="d-flex align-items-center">
                
                <div class="author-avatar rounded-circle ">
                    <img src="{{ $post->user_info->avatar }}" class="">
                </div>
                <div  class="ml-2">
                    <span>
                        <b>{{ $post->user->name }}</b>
                    </span> <br>
                    <span>
                        <b>{{ $post->user_info->surname }}</b>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
