@extends('layouts.admin_template')
@include('fragments.tables')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" 
               data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <button type="button" class="btn btn-default" style="margin: 10px">Создание сделки</button>
            </a>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <br />
                                <form class="form-horizontal form-label-left input_mask" method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }}     
                                    
                                    @if (!empty($objects)) 
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Объект
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">  

                                            <select class="form-control" name='object_id'>   
                                                <option value=""></option>
                                                    @foreach ($objects as $object)
                                                <option value="{{$object->id}}" 
                                                     >{{$object->address}}</option>
                                                    @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if (!empty($customers)) 
                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Покупатель
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">  

                                            <select class="form-control" name='customer_id'>   
                                                <option value=""></option>
                                                @foreach ($customers as $customer)

                                                <option value="{{$customer->id}}" 
                                                        >{{$customer->name}}</option>
                                                @endforeach
                                            </select>  
                                        </div>
                                    </div>
                                    @endif

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
                <h2>Сделки</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Объект</th>
                            <th>Цена</th>
                            <th>Покупатель</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($bargains) > 0)
                        @foreach ($bargains as $bargain)
                        <tr>
                            <td><a href="{{route('bargain', [$bargain])}}">
                                {{$bargain->id}}
                                </a>
                            </td>
                            <td>
                                {{$bargain->object}}
                            </td>                            
                            <td>
                               {{$bargain->price}}
                            </td>
                            <td>
                                @foreach ($customers as $customer)
                                @if (($customer->id) == $bargain->customer_id)
                                {{$customer->name}}
                                @endif
                                @endforeach
                            </td>
                            <td>
                                {{$bargain->status}}
                            </td>
                            <td>
                                <form action="{{route('deleteBargain', [$bargain])}}" method="POST">
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
