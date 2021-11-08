@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Roles</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="/role">Roles</a></li>
                <li class="breadcrumb-item active">Index</li>
            </ol>
        </div><!-- /.col -->
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Roles List</h3>
            <div class="card-tools">
                <button type="button" id="btn-create" class="btn btn-default btn-sm" title="Create New Role">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button type="button" id="btn-delete" class="btn btn-default btn-sm" title="Delete Selected Roles">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <table id="table-role" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 5%;text-align: center;">No</th>
                        <th style="width: 20%;">Code</th>
                        <th>Name</th>
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

    <!--Modal Create-->
    <div class="modal fade" data-backdrop="static" id="modal-create-role">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" id="form-create-role" action="{{ url('/role')}}" method="POST">
                    @csrf
                    <div class="modal-header">
                      <h4 class="modal-title">Form Create Role</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="code" placeholder="Code of the Role">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="name" placeholder="Name of the Role">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--ENDModal Create-->

    <!--Modal Update Role-->
    <div class="modal fade" data-backdrop="static" id="modal-update-role">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" id="form-update-role" action="" method="POST">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="modal-header">
                      <h4 class="modal-title">Form Edit Role</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="form-group row">
                            <label for="code" class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="code" placeholder="Code of the Role">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" name="name" placeholder="Name of the Role">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--ENDModal Update Role-->

    <!--Modal Delete-->
    <div class="modal fade" data-backdrop="static" id="modal-delete-role">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal" id="form-delete-role" action="{{ url('/role/delete')}}" method="POST">
            @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Delete Role Confirmation</h4>
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
    <!--ENDModal Delete-->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        
        var roleDT = $('#table-role').DataTable({
            processing: true,
            serverSide: true,
            select: {
                style: 'multi',
                //selector: 'td:first-child'
            },
            ajax: "{{ url('role/datatables') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
                {data: 'code', name: 'code', render:function(data, type, row, meta){
                    let code_template='';
                        code_template+='<a href="/role/'+row.id+'">';
                        code_template+= data;
                        code_template+='</a>';
                    return code_template;
                }},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center', render:function(data, type, row, meta){
                    let action ='';
                        action+='<button class="btn btn-default btn-xs btn-edit" title="Edit">';
                        action+=    '<i class="fas fa-edit"></i>';
                        action+='</button>';
                    return action;
                }},
            ]
        });


        //Block create trigger button
        $('#btn-create').on('click', function(event){
            event.preventDefault();
            console.log('btn-create is called');
            $('#modal-create-role').modal('show');
            
        });
        //ENDBlock create trigger button

        //Block store role event
        $('#form-create-role').on('submit', function(event){
            event.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('#form-create-role').find("button[type='submit']").prop('disabled', true);
                },
                success: function(data){
                    console.log(data);
                    if(data.status == true){
                        $('#form-create-role')[0].reset();
                        $('#modal-create-role').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: data.message
                        });
                        roleDT.ajax.reload();
                        $('#form-create-role').find("button[type='submit']").prop('disabled', false);
                    }else{
                        $('#form-create-role').find("button[type='submit']").prop('disabled', false);
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
                    $('#form-create-role').find("button[type='submit']").prop('disabled', false);
                }
            });
        });
        //ENDBlock store role event

        //Block Edit trigger button
        roleDT.on('click', '.btn-edit', function(e){
            console.log('Edit');
            let dataRow = roleDT.row( $(this).parents('tr') ).data();
            console.log(dataRow);
            roleDT.rows().deselect();
            $('#form-update-role').attr('action', '/role/'+dataRow.id+'');
            $('#form-update-role').find('input[name="code"]').val(dataRow.code);
            $('#form-update-role').find('input[name="name"]').val(dataRow.name);
            $('#modal-update-role').modal('show');

        });
        //ENDBlock Edit trigger button

        //Block Update Role
        $('#form-update-role').on('submit', function(event){
            event.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('#form-update-role').find("button[type='submit']").prop('disabled', true);
                },
                success: function(data){
                    console.log(data);
                    if(data.status == true){
                        $('#form-update-role')[0].reset();
                        $('#modal-update-role').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: data.message
                        });
                        roleDT.ajax.reload();
                        $('#form-update-role').find("button[type='submit']").prop('disabled', false);
                    }else{
                        $('#form-update-role').find("button[type='submit']").prop('disabled', false);
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
                    $('#form-update-role').find("button[type='submit']").prop('disabled', false);
                }
            });
        });
        //ENDBlock Update Role

        //Block Delete Trigger
        $('#btn-delete').on('click', function(event){
            event.preventDefault();
            let selected_roles = roleDT.rows({selected:true});
            $('#form-delete-role').find("input[name='id[]']").remove();
            if(selected_roles.count() < 1){
                Swal.fire({
                    toast: false,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'warning',
                    title: 'Please select some data'
                });
            }else{
                console.log(selected_roles.data());
                selected_roles.every( function () {
                    let d = this.data();
                    $('#form-delete-role').append('<input type="hidden" name="id[]" value="'+d.id+'"/>');
                });
                $('#modal-delete-role').modal('show');
            }
        });
        //ENDBlock Delete Trigger

        //Block Delete submission
        $('#form-delete-role').on('submit', function(event){
            event.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('#form-delete-role').find("button[type='submit']").prop('disabled', true);
                },
                success: function(data){
                    console.log(data);
                    if(data.status == true){
                        $('#form-delete-role')[0].reset();
                        $('#modal-delete-role').modal('hide');
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: data.message
                        });
                        roleDT.ajax.reload();
                        $('#form-delete-role').find("button[type='submit']").prop('disabled', false);
                    }else{
                        $('#form-delete-role').find("button[type='submit']").prop('disabled', false);
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
                    $('#form-delete-role').find("button[type='submit']").prop('disabled', false);
                }
            });
        });
        //ENDBlock Delete submission
    </script>
@stop
