@extends('layouts.admin_template')
@include('fragments.tables')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" 
               data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <button type="button" class="btn btn-default" style="margin: 10px">Создание объекта</button>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <form class="form-horizontal form-label-left input_mask" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}     
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="address">
                                            Адрес
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="text" class="form-control has-feedback" 
                                                   id="address"  
                                                   name="address" 
                                                   required="required">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Район
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">  

                                            <select class="form-control" name='district_id'>   
                                                <option value=""></option>
                                                    @foreach ($districts as $district)
                                                <option value="{{$district->id}}" 
                                                     >{{$district->name}}</option>
                                                    @endforeach
                                            </select>  
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                               Цена
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 has-feedback">
                                                <input type="text" class="form-control" id="inputSuccess3" 
                                                       name="price">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                               Площадь
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 has-feedback">
                                                <input type="text" class="form-control" id="inputSuccess3" 
                                                       name="yarbage">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" 
                                               for="description">
                                            Описание
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <textarea type="text" 
                                                      id="description" 
                                                      name="description" 
                                                      class="form-control col-md-7 col-xs-12"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Тип
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">  

                                            <select class="form-control" name='is_sale'>   
                                                <option value="1">Продажа</option>
                                                <option value="0">Аренда</option>
                                            </select>  
                                        </div>
                                    </div>
                                    
                                    @if (!empty($owners)) 
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Продавец
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">  

                                            <select class="form-control" name='owner_id'>   
                                                <option value=""></option>
                                                @foreach ($owners as $owner)

                                                <option value="{{$owner->id}}" 
                                                        >{{$owner->name}}</option>
                                                @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 image-object-1" >
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Image 1
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 has-feedback">
                                                <input type="file" class="form-control" id="inputSuccess5" 
                                                       name="image1">
                                            </div>
                                            
                                        </div>   
                                    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Image 2
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 has-feedback">
                                                <input type="file" class="form-control" id="inputSuccess5" 
                                                       name="image2">
                                            </div>
                                            
                                        </div>
                                    <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Image 3
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 has-feedback">
                                                <input type="file" class="form-control" id="inputSuccess5" 
                                                       name="image3">
                                            </div>
                                            
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
                <h2>Объекты</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Адрес</th>
                            <th>Район</th>
                            <th>Тип</th>
                            <th>Цена</th>
                            <th>Продавец</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($objects) > 0)
                        @foreach ($objects as $object)
                        <tr>
                            <td>
                                <a href="{{route('object', [$object])}}">
                                {{$object->id}}
                                </a>
                            </td>
                            <td>
                                <a href="{{route('object', [$object])}}">
                                {{$object->address}}
                                </a>
                            </td>
                            <td>
                                @foreach ($districts as $district)
                                @if (($district->id) == $object->district_id)
                                {{$district->name}}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                @if (($object->is_sale) == 1)
                                Продажа
                                @else 
                                Аренда
                                @endif
                            </td>                            
                            <td>
                               {{$object->price}}
                            </td>
                            <td>
                                {{$object->owner}}
                            </td>
                            <td>
                                {{$object->status}}
                            </td>
                            <td>
                                <form action="{{route('deleteObject', [$object])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button>Delete</button>
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

@endsection


@section('foot')

@yield('dynamic_foot')

@endsection