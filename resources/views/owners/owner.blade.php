@extends('layouts.admin_template')

@section('content')


<div class="x_panel">
    <div class="x_title">
        <h2>Продавец №{{$owner->id}}</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form data-parsley-validate class="form-horizontal form-label-left" 
              enctype="multipart/form-data"
              method="POST" action="{{route('updateOwner', [$owner])}}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}  
 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="name">
                    Имя
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="name" 
                           name="name" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$owner->name}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="phone">
                    Телефон
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$owner->phone}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="price">
                    Тип
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name='is_developer'>   
                            <option value="{{$owner->is_developer}}">
                                @if ($owner->is_developer == 1) 
                                Застройщик
                                <option value="0" 
                                    >Собственник</option>
                                @else 
                                Собственник
                                <option value="1" 
                                    >Застройщик</option>
                                @endif
                            </option>
                    </select>  
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


