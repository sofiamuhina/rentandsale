<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap -->
        <link href="/css/bootstrap.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="/css/font-awesome.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="/css/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="/css/animate.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="/css/custom.css" rel="stylesheet">
        <style>
            
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            body {
                background-color:white;
                /*background-image: url("/images/background_login.jpg");
                background-size: 100%;
                background-repeat: no-repeat;
                background-position: left top;
                overflow: hidden;*/
            }            
            .login_content h1:before, .login_content h1:after {
                background: white;
            }
            .login_logo {
                height: 200px
            }
            @media screen and (max-width: 960px) {
                body {
                    background-size: auto 100%;
                    background-repeat: no-repeat;
                    background-position: top;
                }
            }            

            .content {
                position: relative;
                top: 30%;
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .title {
                font-size: 5em;
            }
        </style>
    </head>

    <body >
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <!--<img class="login_logo" src="/images/logo.png">-->
                        <span class="title">
                            Shocas
                        </span>

                        <form method="POST" action="{{route('login')}}">
                            {{ csrf_field() }}
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            <br/>
                            <div>
                                <input type="text" class="form-control" placeholder="Email" required="" name="email"/>
                            </div>
                            <div>
                                <input type="password" class="form-control" placeholder="Password" required="" name="password"/>
                            </div>
                            <div>
                                <button class="btn btn-default" submit>Log in</button>
                                <a class="reset_pass" href="#">Forgot password?</a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>