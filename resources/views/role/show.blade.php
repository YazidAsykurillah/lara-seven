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
                <form class="form-horizontal" id="form-update-role-permission" action="{{ url('/role/update-permission')}}" method="POST">
                    @csrf
                    <div class="card-header">
                        <h3 class="card-title">Permissions List</h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        @if($permissions->count())
                            @foreach($permissions as $permission)
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permission_name[]" value="{{ $permission->name }}" {{ $role->hasPermissionTo($permission->name) == true ? "checked" :"" }} >
                                    <label class="form-check-label">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        
                    </div>
                    
                    <div class="card-footer">
                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                        <button type="submit" class="btn btn-default float-right">Update Permission</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script type="text/javascript">
    $('#form-update-role-permission').on('submit', function(event){
        event.preventDefault();
        let url = $(this).attr('action');
        $.ajax({
            type: 'post',
            url: url,
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend:function(){
                $('#form-update-role-permission').find("button[type='submit']").prop('disabled', true);
            },
            success: function(data){
                console.log(data);
                if(data.status == true){
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'success',
                        title: data.message
                    });
                    $('#form-update-role-permission').find("button[type='submit']").prop('disabled', false);
                }else{
                    $('#form-update-role-permission').find("button[type='submit']").prop('disabled', false);
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
                $('#form-update-role-permission').find("button[type='submit']").prop('disabled', false);
            }
        });
    });
</script>
@stop
