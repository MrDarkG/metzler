@extends('layouts.user')

@section("inlinecss")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
@endsection

@section('content')
<div class="container">
    
    <div class="card table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                        <td>
                            <div class="d-flex justify-content-start">
                                <div class="col-md-6 d-flex justify-content-center">
                                    
                                    <a href="{{ route('user.admin.edit',["id"=>$user->id]) }}" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt "></i>
                                        
                                    </a>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <form method="POST" action="{{ route('user.admin.destroy') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button class="btn btn-danger" data-toggle="tooltip" title="Be Careful. You will delete ALl information about user  and user's post too! Are you sure about it?">
                                            <i class="fas fa-trash "></i>
                                            
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> 
    </div>
</div>
@endsection


