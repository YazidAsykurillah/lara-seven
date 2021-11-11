@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/home"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="/user">Users</a></li>
                <li class="breadcrumb-item"><a href="/user/{{ $user->id }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div><!-- /.col -->
    </div>
@stop

@section('content')
    <div class="card">
        <form class="" id="form-update-user" action="{{ url('/user/'.$user->id.'')}}" method="POST">
            @csrf
            {{ method_field('PUT') }}
            <div class="card-header">
                Form Edit User
            </div>
            <div class="card-body">
                <div class="row">
                    <!--General Information-->
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
                                        <input type="text" class="form-control" name="name" placeholder="Name of the user" value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" placeholder="Email of the user" value="{{ $user->email }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--END General Information-->

                    <!--Role Options-->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">Roles</div>
                            <div class="card-body">
                                <div class="form-group">
                                @if($role_options->count() >0)
                                    @foreach($role_options as $role_option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="role_name[]" value="{{ $role_option->name }}" {{ $user->hasRole($role_option->name) == true ? "checked" :"" }} >
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
                    <!--END Role Options-->
                </div>
            </div>
            <div class="card-footer">
                <a href="/user" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Save</button>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript">
        $('#manage-user-menu').find('.nav-link').addClass('active');
        
        //Block store user event
        $('#form-update-user').on('submit', function(event){
            event.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend:function(){
                    $('#form-update-user').find("button[type='submit']").prop('disabled', true);
                },
                success: function(data){
                    console.log(data);
                    if(data.status == true){
                        $('#form-update-user')[0].reset();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            icon: 'success',
                            title: data.message
                        });
                        $('#form-update-user').find("button[type='submit']").prop('disabled', false);
                        window.location.href = data.data.url;
                    }else{
                        $('#form-update-user').find("button[type='submit']").prop('disabled', false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    let errors = jqXHR.responseJSON;
                    console.log(errors);
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
                        subtitle: ' Validation error',
                        body: error_template
                    });
                    $('#form-update-user').find("button[type='submit']").prop('disabled', false);
                }
            });
        });
        //ENDBlock store user event
        
    </script>
@stop
