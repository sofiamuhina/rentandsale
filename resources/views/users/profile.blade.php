@extends('layouts.admin_template')

@section('content')


<div class="x_panel">
    <div class="x_title">
        <h2>Редактирование профиля</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form data-parsley-validate class="form-horizontal form-label-left" 
              enctype="multipart/form-data"
              method="POST" action="{{route('updateUser', [$user])}}">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}  


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="firstname">
                    Имя
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="firstname" 
                           name="name"
                           class="form-control col-md-7 col-xs-12"
                           value="{{$user->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="email" 
                       class="control-label col-md-3 col-sm-3 col-xs-12">
                    Электронный адрес
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="email" 
                           class="form-control col-md-7 col-xs-12" 
                           type="email" 
                           name="email"
                           value="{{$user->email}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Пароль 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="password" 
                           class="form-control col-md-7 col-xs-12" 
                           type="password"
                           name="password">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Подтверждение пароля
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="password_confirmation" 
                           class="form-control col-md-7 col-xs-12"
                           type="password"
                           name="password_confirmation">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">
                    Телефон
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="phone" class="form-control col-md-7 col-xs-12" 
                           type="tel"
                           name="phone"
                           value="{{$user->phone}}">
                </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Отменить</button>
                    <button type="submit" class="btn btn-success">Сохранить</button>
                </div>
            </div>

        </form>
    </div>
</div>




@endsection

@section('head')

<link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

@endsection

@section('foot')

<script src="/vendors/iCheck/icheck.min.js"></script>

@endsection
