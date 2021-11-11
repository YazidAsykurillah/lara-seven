@extends('adminlte::page')

@section('title', 'Create User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Create User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="/user">Users</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div><!-- /.col -->
    </div>
@stop

@section('content')
    <form class="" id="form-crete-user" action="{{ url('/user')}}" method="POST">
        @csrf
    <div class="row">
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">General Information</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" placeholder="Name of the user">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" placeholder="Email of the user">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Roles</div>
                <div class="card-body">
                    <div class="form-group">
                    @if($role_options->count() >0)
                        @foreach($role_options as $role_option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="role_name[]" value="{{ $role_option->name }}">
                            <label class="form-check-label">
                                {{ $role_option->name }}
                            </label>
                        </div>
                        @endforeach
                    @endif
                  </div>
                </div>
            </div>
        </div>
        
    </div>
    </form>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        
    </script>
@stop
