@extends('layouts.admin_template')
@include('fragments.tables')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" 
               data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <button type="button" class="btn btn-default" style="margin: 10px">Создание пользователя</button>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <form class="form-horizontal form-label-left input_mask"  method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}       
                                    
                                    @if (!empty($roles))
                                    <div class="col-md-offset-6">
                                        <div name="role_id" class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Роль
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">  
                                                @foreach ($roles as $role)
                                                <div class="col-md-4 col-sm-4 col-xs-6">  
                                                <input class="flat" 
                                                       type="checkbox" 
                                                       name="roles[]" 
                                                       value="{{$role->id}}">&nbsp;{{$role->name}}<br>
                                                </div>
                                                @endforeach                                      
                                            </div>
                                        </div>   
                                    </div>
                                    @endif                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="firstname">
                                            Имя
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control has-feedback" 
                                                   id="inputSuccess2" 
                                                   name="name" 
                                                   required="required">
                                            <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="email">
                                            Электронный адрес
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control has-feedback" 
                                                   id="inputSuccess4" 
                                                   name="email"
                                                   required="required">
                                            <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="phone">
                                            Телефон
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" id="inputSuccess5" 
                                                   placeholder="8 911 777 77 77"
                                                   name="phone">
                                            <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div> 

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="password">
                                            Пароль
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="password" class="form-control has-feedback" 
                                                   id="inputSuccess6" 
                                                   placeholder="Не менее 6 символов"
                                                   name="password"
                                                   required="required">
                                            <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="password_confirmation">
                                            Подтверждение пароля
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="password" class="form-control" id="inputSuccess7" 
                                                   name="password_confirmation">
                                            <span class="fa fa-lock form-control-feedback right" aria-hidden="true"></span>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <br />
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                            <a class="btn btn-primary" href="#collapseOne" data-toggle="collapse">Cancel</a>
                                            <button class="btn btn-primary" type="reset">Reset</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Пользователи</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($users) > 0)
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>
                                <a href="{{route('user', [$user])}}">
                                    {{ $user->name }}
                                </a>
                            </td>                            
                            <td>
                                {{$user->email }}
                            </td>
                            <td>
                                <form action="{{route('deleteUser', [$user])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button>Удалить</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('head')

@yield('dynamic_head')
<link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

@endsection


@section('foot')

@yield('dynamic_foot')
<script src="/vendors/iCheck/icheck.min.js"></script>

@endsection