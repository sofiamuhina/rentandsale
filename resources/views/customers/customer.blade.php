@extends('layouts.admin_template')

@section('content')


<div class="x_panel">
    <div class="x_title">
        <h2>Покупатель №{{$customer->id}}</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form data-parsley-validate class="form-horizontal form-label-left" 
              enctype="multipart/form-data"
              method="POST" action="{{route('updateCustomer', [$customer])}}">
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
                           value="{{$customer->name}}">
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
                           value="{{$customer->phone}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="requirements">
                    Требования
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                     <input type="text" 
                           id="requirements" 
                           name="requirements" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$customer->requirements}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="price">
                    Тип
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name='is_sale'>   
                            <option value="{{$customer->is_sale}}">
                                @if ($customer->is_sale == 1) 
                                Хочет купить
                                <option value="0" 
                                    >Хочет снять</option>
                                @else 
                                Хочет снять
                                <option value="1" 
                                    >Хочет купить</option>
                                @endif
                            </option>
                    </select>  
                </div>
            </div>
            <div class=" form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Статус
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">  

                        <select class="form-control" name='status_id'>   
                            <option value="{{$customer->status_id}}">{{$customer->status}}</option>
                                  @foreach ($statuses as $status)
                                  @if (!($customer->status_id == $status->id))
                            <option value="{{$status->id}}" 
                                    >{{$status->name}}</option>
                                   @endif
                                   @endforeach
                        </select>  
                    </div>
            </div>
            <div class=" form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Ответственный сотрудник
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">  

                        <select class="form-control" name='user_id'>   
                            <option value="{{$customer->user_id}}">{{$customer->user}}</option>
                                  @foreach ($users as $user)
                                  @if (!($customer->user_id == $user->id))
                            <option value="{{$user->id}}" 
                                    >{{$user->name}}</option>
                                   @endif
                                   @endforeach
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


