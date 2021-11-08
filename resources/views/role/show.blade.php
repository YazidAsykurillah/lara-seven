@extends('adminlte::page')

@section('title', 'Role :: '.$role->code)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Role Detail</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="/role">Roles</a></li>
                <li class="breadcrumb-item"><a href="/role/{{$role->id}}">{{ $role->code }}</a></li>
                <li class="breadcrumb-item active">Show</li>
            </ol>
        </div><!-- /.col -->
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role Information</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Code</b> <a class="float-right">{{ $role->code }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Name</b> <a class="float-right">{{ $role->name }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Guard</b> <a class="float-right">{{ $role->guard_name }}</a>
                        </li>
                    </ul>
                </div>
                <!-- /.card-body -->
                <div class="card-footer"></div>
                <!-- /.card-footer-->
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Permissions Information</h3>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    
                </div>
                <!-- /.card-body -->
                <div class="card-footer"></div>
                <!-- /.card-footer-->
            </div>
        </div>
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
