@extends('layouts.admin_template')

@section('content')


<div class="x_panel">
    <div class="x_title">
        <h2>Сделка №{{$bargain->id}}</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form data-parsley-validate class="form-horizontal form-label-left" 
              enctype="multipart/form-data"
              method="POST" action="{{route('updateBargain', [$bargain])}}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}  
 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="object">
                    Объект
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="object" 
                           name="object_id" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$bargain->object}}" disabled>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="price">
                    Цена
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="price" 
                           name="price" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$bargain->price}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="customer">
                    Покупатель
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="customer" 
                           name="customer_id" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$bargain->customer}}" disabled>
                </div>
            </div>
            <div class=" form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Статус
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">  

                        <select class="form-control" name='status_id'>   
                            <option value="{{$bargain->status_id}}">{{$bargain->status}}</option>
                                  @foreach ($statuses as $status)
                                  @if (!($bargain->status_id == $status->id))
                            <option value="{{$status->id}}" 
                                    >{{$status->name}}</option>
                                   @endif
                                   @endforeach
                        </select>  
                    </div>
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


