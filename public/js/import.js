var accessTokenCookie = 'accessToken';
jQuery().ready(function () {
    var input = jQuery('#input_file')[0];
    input = document.getElementById('import_file');

    var rABS = true; // true: readAsBinaryString ; false: readAsArrayBuffer
    function handleFile(e) {
        var files = e.target.files, f = files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            var data = e.target.result;
            if (!rABS)
                data = new Uint8Array(data);
            var workbook = XLSX.read(data, {type: rABS ? 'binary' : 'array'});

            console.log(workbook);
            console.log(XLSX.utils.sheet_to_json(
                    workbook.Sheets[workbook.SheetNames[0]]));

            setSubmitListener(workbook);

        };
        if (rABS)
            reader.readAsBinaryString(f);
        else
            reader.readAsArrayBuffer(f);
    }
    input.addEventListener('change', handleFile, false);


});

function setSubmitListener(workbook) {
    jQuery("#submit_file").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: '/tokenBySession',
            success: function (data) {
                console.log(data);
                Cookies.set(accessTokenCookie, data.accessToken);
                importFile(workbook);
            }
        });
    });
}

function importFile(workbook) {
    var upload = {};
    var objects = XLSX.utils.sheet_to_json(
            workbook.Sheets[workbook.SheetNames[0]]);
    upload.params = {
        store_id: jQuery('#store_id').val(),
        price_multiplier: jQuery('#price_multiplier').val()
    }

    console.log(objects.length);

    //objects = objects.slice(0, 4);
    
    var maxSize = 500;
    
    
    for (var sizeSent = 0; sizeSent < objects.length; sizeSent += maxSize) {
        
        if (sizeSent + maxSize > objects.length) {
            maxSize = objects.length - sizeSent;
        }
        
        var currentSlice = objects.slice(sizeSent, sizeSent + maxSize);
        console.log(currentSlice.length);
        upload.objects = currentSlice;
        sendImportObjects(upload);
    }
    
    
}

function sendImportObjects(json) {
    $.ajax({
        type: "POST",
        url: '/api/product/import',
        headers: {
            'Authorization': 'Bearer ' + Cookies.get(accessTokenCookie)
        },
        dataType: "json",
        data: JSON.stringify(json),
        success: function (data) {
            console.log(data);
        }
    });
}




function example() {
    jQuery().ready(function () {
        var socket = io.connect('/', {
            path: '/api/node/socket.io',
            /*extraHeaders: {
             'Authorization': 'Bearer ' + Cookies.get(accessTokenCookie),
             'blabla': 'blablabla'
             }*/
        });
        /*var accessTokenCookie = 'accessToken';
         socket.on('user/' + {{ Auth::user() - > id }
         }, function (data) {
         showMessage(data);
         });*/
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
                jQuery().ajax({
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
    }
    );
}