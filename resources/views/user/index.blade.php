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

    <!--Modal Delete User-->
    <div class="modal fade" data-backdrop="static" id="modal-delete-user">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal" id="form-delete-user" action="{{ url('/user/delete')}}" method="POST">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Delete User Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><i class="fas fa-info-circle"></i> Selected data will be deleted</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                </div>
            </form>
          </div>
        </div>
    </div>
    <!--ENDModal Delete User-->


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
                {data: 'name', name: 'name', render:function(data, type, row, meta){
                    let name_template='';
                        name_template+='<a href="/user/'+row.id+'">';
                        name_template+= data;
                        name_template+='</a>';
                    return name_template;
                }},
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
                        action+='<a href="/user/'+row.id+'/edit" class="btn btn-default btn-xs btn-edit" title="Edit">';
                        action+=    '<i class="fas fa-edit"></i>';
                        action+='</a>';
                    return action;
                }},
            ]
        });

        //Block Delete Trigger
        $('#btn-delete').on('click', function(event){
            event.preventDefault();
            let selected_users = userDT.rows({selected:true});
            $('#form-delete-user').find("input[name='id[]']").remove();
            if(selected_users.count() < 1){
                Swal.fire({
                    toast: false,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'warning',
                    title: 'Please select some data'
                });
            }else{
                console.log(selected_users.data());
                selected_users.every( function () {
                    let d = this.data();
                    $('#form-delete-user').append('<input type="hidden" name="id[]" value="'+d.id+'"/>');
                });
                $('#modal-delete-user').modal('show');
            }
        });
        //ENDBlock Delete Trigger

        //Block Delete submission
        $('#form-delete-user').on('submit', function(event){
            event.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('#form-delete-user').find("button[type='submit']").prop('disabled', true);
                },
                success: function(data){
                    console.log(data);
                    if(data.status == true){
                        $('#form-delete-user')[0].reset();
                        $('#modal-delete-user').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: data.message
                        });
                        userDT.ajax.reload();
                        $('#form-delete-user').find("button[type='submit']").prop('disabled', false);
                    }else{
                        $('#form-delete-user').find("button[type='submit']").prop('disabled', false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    let errors = jqXHR.responseJSON;
                    //console.log(errors);
                    let error_template = "";
                    //console.log(textStatus);
                    $.each( errors.errors, function( key, value ){
                        console.log(value);
                        error_template += '<p>'+value+ '</p>'; //showing only the first error.
                    });
                    console.log(error_template);
                    $(document).Toasts('create',{
                        class: 'bg-danger',
                        position: 'bottomRight',
                        autohide: true,
                        delay: 5000,
                        icon: 'fas fa-exclamation-circle',
                        title: 'Error',
                        subtitle: 'Validation error',
                        body: error_template
                    });
                    $('#form-delete-user').find("button[type='submit']").prop('disabled', false);
                }
            });
        });
        //ENDBlock Delete submission

    </script>
@stop
