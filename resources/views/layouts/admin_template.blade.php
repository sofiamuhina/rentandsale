<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rent And Sale</title>

        <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!--<link href="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>-->

        <link href="/css/custom.css" rel="stylesheet">
        <script src="/vendors/jquery/dist/jquery.min.js"></script>
        <script src="/js/manager.js"></script>

        @yield('head')
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="/" class="site_title">
                                <span>Rent And Sale</span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li><a href='/'>
                                            <i class="fa fa-bar-chart"></i> 
                                            Dashboard
                                        </a>
                                    </li>
                                    <li><a href='{{route('userlist')}}'>
                                            <i class="fa fa-user"></i> 
                                            Пользователи
                                        </a>
                                    </li>  
                                    <li><a href='{{route('objectlist')}}'>
                                            <i class="fa fa-user"></i> 
                                            Объекты
                                        </a>
                                    </li> 
                                     <li><a href='{{route('bargainlist')}}'>
                                            <i class="fa fa-user"></i> 
                                            Сделки
                                        </a>
                                    </li> 

                                    <li><a href='{{route('ownerlist')}}'>
                                            <i class="fa fa-desktop"></i> 
                                            Продавцы
                                        </a>
                                    </li>
                                    <li><a href='{{route('customerlist')}}'>
                                            <i class="fa fa-desktop"></i> 
                                            Клиенты
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->            
                        <!--<div class="sidebar-footer"></div>-->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                        @if (!empty($currentUser))
                                        {{$currentUser->name}}
                                        @endif
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-usermenu pull-right" style="width: 73px !important; min-width: 60px !important;">
                                       
                                            <form  method="POST" action="/admin/logout">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-default" style="border-color: white !important;">Log Out</button>
                                            </form>
                                        
                                    </div>
                                </li>
  
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <div class="right_col" role="main">

                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    <br/>

                    @yield('content')

                </div>

                <!-- footer content -->
                <footer class="footer_fixed">
                    <div class="pull-right">
                        <!--<image src="/images/leeloo_no_background.png" class="image" style="height: 30px"/>-->
                        <br/>
                        <br/>
                    </div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="/vendors/fastclick/lib/fastclick.js"></script>
        <script src="/vendors/nprogress/nprogress.js"></script>
        <script src="/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
         <script>
            <?php 
            if (isset($districts)) {
                $num = 1;
              foreach ($districts as $district) { 
                if(($district->id) == $num) $dist[$num] = $district->count;
                $num ++;
              }
            }
            if (isset($users)) {
                $num = 1;
              foreach ($users as $user) { 
                if(($user->id) == $num) $user_pr[$num] = $user->profit;
                $num ++;
              }
            }
            ?>
            var dist1 = '<?php if (isset($dist[1])) echo $dist[1]; ?>';
            var dist2 = '<?php if (isset($dist[2])) echo $dist[2]; ?>';
            var dist3 = '<?php if (isset($dist[3])) echo $dist[3]; ?>';
            var dist4 = '<?php if (isset($dist[4])) echo $dist[4]; ?>';
            var dist5 = '<?php if (isset($dist[5])) echo $dist[5]; ?>';
            var dist6 = '<?php if (isset($dist[6])) echo $dist[6]; ?>';
            var dist7 = '<?php if (isset($dist[7])) echo $dist[7]; ?>';
            
            var user1 = '<?php if (isset($user_pr[1])) echo $user_pr[1]; ?>';
            var user2 = '<?php if (isset($user_pr[2])) echo $user_pr[2]; ?>';
            var user3 = '<?php if (isset($user_pr[3])) echo $user_pr[3]; ?>';
        </script>
        <script src="/js/custom.js"></script>
        
        @yield('foot')

    </body>
</html>