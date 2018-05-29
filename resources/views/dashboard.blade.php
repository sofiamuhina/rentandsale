@extends('layouts.admin_template')

@section('content')

<div class="row">
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top">
                <i class="fa fa-user"></i>
                Новых объектов/день
            </span>
            <div class="count">
                {{$objects_day}}
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top">
                <i class="fa fa-user"></i>
                Новых объектов/неделя
            </span>
            <div class="count">
                {{$objects_week}}
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top">
                <i class="fa fa-user"></i>
                Новых объектов/месяц
            </span>
            <div class="count">
                {{$objects_month}}
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top">
                <i class="fa fa-user"></i>
                Успешных сделок/месяц
            </span>
            <div class="count">
                {{$bargains_month}}
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top">
                <i class="fa fa-user"></i>
                Успешных сделок/год
            </span>
            <div class="count">
                {{$bargains_year}}
            </div>
        </div>
    </div>

           <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Количество объектов по районам</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: flex;">
                <canvas id="canvasDoughnut"></canvas>
            </div>   
        </div>
    </div>




</div>

@endsection

@section('head')



@endsection

@section('foot')

<script src="/vendors/Chart.js/dist/Chart.min.js"></script>

@endsection