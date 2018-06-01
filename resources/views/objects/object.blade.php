@extends('layouts.admin_template')

@section('content')


<div class="x_panel">
    <div class="x_title">
        <h2>Объект №{{$object->id}}</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <br />
        <form data-parsley-validate class="form-horizontal form-label-left" 
              enctype="multipart/form-data"
              method="POST" action="{{route('updateObject', [$object])}}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}  
 


               <!--   <div class=" form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Статус
                          </label>
                          <div class="col-md-6 col-sm-6 col-xs-12">  

                           <select class="form-control" name='status_id'>   
                           <option value="{{$object->status_id}}">{{$object->status}}</option>
                                  @foreach ($statuses as $status)
                                  @if (!($object->status_id == $status->id))
                                  <option value="{{$status->id}}" 
                                    >{{$status->name}}</option>
                                    @endif
                                    @endforeach
                            </select>  
                           </div>
                  </div> -->

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="address">
                    Адрес
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="address" 
                           name="address" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$object->address}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="description">
                    Описание
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="description" 
                           name="description" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$object->description}}">
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
                           value="{{$object->price}}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                       for="yardage">
                    Площадь
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" 
                           id="yardage" 
                           name="yardage" 
                           class="form-control col-md-7 col-xs-12"
                           value="{{$object->yardage}}">
                </div>
            </div>
            <div class=" form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Статус
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">  

                        <select class="form-control" name='status_id'>   
                            <option value="{{$object->status_id}}">{{$object->status}}</option>
                                  @foreach ($statuses as $status)
                                  @if (!($object->status_id == $status->id))
                            <option value="{{$status->id}}" 
                                    >{{$status->name}}</option>
                                   @endif
                                   @endforeach
                        </select>  
                    </div>
            </div>
            <div class=" form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Район
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">  

                        <select class="form-control" name='district_id'>   
                            <option value="{{$object->district_id}}">{{$object->district}}</option>
                                  @foreach ($districts as $district)
                                  @if (!($object->district_id == $district->id))
                            <option value="{{$district->id}}" 
                                    >{{$district->name}}</option>
                                   @endif
                                   @endforeach
                        </select>  
                    </div>
            </div>
            <div class=" form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">
                         Продавец
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">  

                        <select class="form-control" name='owner_id'>   
                            <option value="{{$object->owner_id}}">{{$object->owner}}</option>
                                  @foreach ($owners as $owner)
                                  @if (!($object->owner_id == $owner->id))
                            <option value="{{$owner->id}}" 
                                    >{{$owner->name}}</option>
                                   @endif
                                   @endforeach
                        </select>  
                    </div>
            </div>
            @if (!empty($images))
            <div class="row">
                <div class="col-md-20">
                    <divjn class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                @foreach($images as $image)
                                <div class="col-md-55">
                                    <div class="image view view-first">
                                        <a href="#" data-toggle="modal" data-target="#modal_{{$image->id}}">
                                            <img style="width: 100%; display: block;" src="/images/{{$image->path}}" alt="image" />
                                        </a>       
                                    </div>
                                </div> 
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
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


