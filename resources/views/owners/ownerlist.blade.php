@extends('layouts.admin_template')
@include('fragments.tables')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" 
               data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <button type="button" class="btn btn-default" style="margin: 10px">Создание продавца</button>
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
                                               for="name">
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

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                                Телефон
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12 has-feedback">
                                                <input type="text" class="form-control" id="inputSuccess3" 
                                                       name="phone">
                                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 col-lg-6 form-group has-feedback">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Тип
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">  

                                            <select class="form-control" name='is_developer'>   
                                                <option value="1">Застройщик</option>
                                                <option value="0">Собственник</option>
                                            </select>  
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
                <h2>Продавцы</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Тип</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($owners) > 0)
                        @foreach ($owners as $owner)
                        <tr>
                            <td>
                                <a href="{{route('owner', [$owner])}}">
                                {{$owner->id}}
                                </a>
                            </td>
                            <td>
                                <a href="{{route('owner', [$owner])}}">
                                    {{$owner->name}}
                                </a>
                            </td>
                                
                            <td>
                                {{$owner->phone}}
                            </td>                            
                            <td>
                               @if (($owner->is_developer) == 1)
                                Застройщик
                                @else 
                                Собственник
                                @endif
                            </td>
                            <td>
                                <form action="{{route('deleteOwner', [$owner])}}" method="POST">
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