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
        <link href="nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="/css/animate.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="/css/custom.css" rel="stylesheet">
        <style>
            body {
                background-color:white;
            }
            .login_content h1:before, .login_content h1:after {
                background: white;
            }
        </style>
    </head>

    <body >
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <img src="/images/logo.png">

                        <form method="POST" action="/forgot_password">
                            {{ csrf_field() }}
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            <br/>
                            <div>
                                <input type="text" class="form-control" placeholder="Email" required="" name="email"/>
                            </div>
                            <div>
                                <button class="btn btn-default" submit>Сбросить пароль</button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>