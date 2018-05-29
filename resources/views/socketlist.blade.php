@extends('layouts.admin_template')
@include('fragments.tables')

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Connected sockets</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>                            
                            <th>User</th>
                            <th>Socket id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($sockets) > 0)
                        @foreach ($sockets as $socket)
                        <tr>                            
                            <td>
                                <a href="{{route('user', [$socket->user])}}">
                                    {{ $socket->user->name }}
                                </a>
                            </td>    
                            <td>
                                {{$socket->socket_id }}
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