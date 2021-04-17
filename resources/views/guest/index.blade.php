@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @foreach ($posts as $post)
            <a href="{{ route('show',["id"=>$post->id]) }}" class="col-md-4 mb-4">
                <div class="d-flex flex-column costum-card ">
                    <div>
                        <span class="post-title">{{ $post->title }} </span> <br>
                        <span class="post-date">{{ $post->created_at }}</span>
                    </div>
                    <div class="">
                        <img class="post-image" src="{{ $post->picture }}">
                        <span>
                            {{ $post->shorten_content }}
                        </span>
                    </div>
                    
                </div>
            </a>    
        @endforeach
    </div>
    {{-- since this has problem i have to configure pagination manually --}}
    {{-- {{ $posts->links() }} --}}
    <div class="row justify-content-center">
        
        <a class="pagination-links" href="{{$posts->previousPageUrl()==null?"#":$posts->previousPageUrl()}}">
            <
        </a>
        @for($i=0;$i<$posts->lastPage();$i++)

            <a href="{{$posts->url($i+1)}}" class="pagination-links {{ $posts->currentPage()  == $i+1?"pagination-active":''}}">{{$i + 1}}</a>
        @endfor
        <a class="pagination-links" href="{{$posts->nextPageUrl()==null?"#":$posts->nextPageUrl()}}">
            >
        </a>
    </div>
</div>
@endsection
