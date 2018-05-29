@extends('layouts.admin_template')
@section('content')
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<style type="text/css">
    #messages{
        border: 1px solid black;
        height: 300px;
        margin-bottom: 8px;
        overflow: scroll;
        padding: 5px;
    }
</style>
<div class="container spark-screen">
    <div class="row">
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Chat Message Module</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" >
                            <div id="messages" ></div>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" >
                            <form action="sendmessage" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                                <input type="hidden" name="user" value="{{ Auth::user()->name }}" >
                                <textarea class="form-control msg"></textarea>
                                <br/>
                                <input type="button" value="Send" class="btn btn-success send-msg">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
jQuery().ready(function () {
    var socket = io.connect('/', {
        path: '/api/node/socket.io',
        /*extraHeaders: {
            'Authorization': 'Bearer ' + Cookies.get(accessTokenCookie),
            'blabla': 'blablabla'
        }*/
    });
    var accessTokenCookie = 'accessToken';
    socket.on('user/' + {{ Auth::user()->id }}, function (data) {
        showMessage(data);
    });
    socket.on('message', function (data) {
        showMessage(data);
    });

    function showMessage(data) {
        console.log(data);
        jQuery("#messages").append("<strong>" + data.user + ":</strong><p>" + data.message + "</p>");
        textAr = $("#messages");
        if (textAr.length) {
            textAr.scrollTop(textAr[0].scrollHeight - textAr.height());
        }
    }
    socket.on('connect', function (data) {
        console.log('connected');
        socket.emit('authenticate', {authorization: 'Bearer ' + Cookies.get(accessTokenCookie)});
    });

    jQuery(".send-msg").click(function (e) {
        e.preventDefault();
        if (!Cookies.get(accessTokenCookie)) {
            $.ajax({
                type: "GET",
                url: '{!! URL::to("tokenBySession") !!}',
                success: function (data) {
                    console.log(data);
                    Cookies.set(accessTokenCookie, data.accessToken);
                    sendMessage();
                }
            });
        } else {
            sendMessage();
        }
    });
    function sendMessage() {
        var token = $("input[name='_token']").val();
        var user = $("input[name='user']").val();
        var msg = $(".msg").val();
        $(".msg").focus();
        if (msg != '') {
            $.ajax({
                type: "POST",
                //url: '{!! URL::to("testMessageSend") !!}',
                url: '{!! URL::to("api/sendChatMessage") !!}',
                headers: {
                    'Authorization': 'Bearer ' + Cookies.get(accessTokenCookie)
                },
                dataType: "json",
                data: {
                    //'_token': token, 
                    'channel': 'message',
                    'message': msg,
                    //'user': user
                },
                success: function (data) {
                    console.log(data);
                    $(".msg").val('');
                }
            });
        }
    }
});
</script>
@endsection