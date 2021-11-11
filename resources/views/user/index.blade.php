@extends('adminlte::page')

@section('title', 'Users')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="/user">Users</a></li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users List</h3>
            <div class="card-tools">
                <a href="/user/create" class="btn btn-default btn-sm" title="Create New user">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                <button type="button" id="btn-delete" class="btn btn-default btn-sm" title="Delete Selected Users">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="table-user" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;text-align: center;">No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th style="width:10%; text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
    </div>


@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        
        var userDT = $('#table-user').DataTable({
            processing: true,
            serverSide: true,
            select: {
                style: 'multi',
                //selector: 'td:first-child'
            },
            ajax: "{{ url('user/datatables') }}",
            columns: [
                {data: 'rownum', name: 'rownum', searchable:false},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'roles', name: 'roles.name', orderable:false, render:function(data, type, row, meta){

                    let roles_template = '';
                    if(row.roles.length >0){
                        $.each( row.roles, function( key, value ){
                            roles_template+='<span class="badge bg-info">';
                            roles_template+=    value.name;
                            roles_template+='</span>&nbsp;';
                        });
                    }
                    return roles_template;
                }},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center', render:function(data, type, row, meta){
                    let action ='';
                        action+='<button class="btn btn-default btn-xs btn-edit" title="Edit">';
                        action+=    '<i class="fas fa-edit"></i>';
                        action+='</button>';
                    return action;
                }},
            ]
        });

    </script>
@stop
