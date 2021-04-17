@extends('layouts.user')

@section('content')
<div class="container">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Hello! You make it!</h4>
      <p>Now you are in sort of admin panel from where you can create posts etc.</p>
      <p class="mb-0">It deppends on ur roles and privilegies.</p>
    </div>
    <div class="row justify-content-start">
        @foreach ($posts as $post)
            <div  class="col-md-4 mb-4" >
                <div class="d-flex flex-column costum-card ">
                    <div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ route('show',["id"=>$post->id]) }}">
                                    
                                    <span class="post-title">{{ $post->title }} </span> 
                                </a>
                            </div>
                            <div class="d-flex">
                                
                                @role("writer|admin")

                                    <div class="">
                                        <a class="bg-transparent btn" href="{{ route('user.posts.edit',["id"=>$post->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                @endrole
                                @role("writer|admin")
                                

                                    <div class="">
                                        <form  method="POST" id="deletepost" action="{{ route('user.posts.save') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $post->id }}">
                                            <button class="bg-transparent btn"> 
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endrole
                                
                            </div>

                        </div>
                        <span class="post-date">{{ $post->created_at }}</span>
                    </div>
                    <a href="{{ route('show',["id"=>$post->id]) }}">
                        <img class="post-image" src="{{ $post->picture }}">
                        <span>
                            {{ $post->shorten_content }}
                        </span>
                    </a>
                    
                </div>
            </div>    
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
