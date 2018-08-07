$(document).ready(function () {
    // var socket = new WebSocket("ws://echo.websocket.org");
    // var status = $('div.result');
    //
    // socket.onopen = function (p1) {
    //     status.html('connected');
    // }
    //
    // socket.onclose = function (p1) {
    //     if (p1.wasClean){
    //         status.html('connection closed')
    //     } else {
    //         status.html('there was some error')
    //     }
    //     status.append(p1.code + p1.reason)
    // }
    //
    // socket.onmessage = function (p1) {
    //     status.html(p1.data)
    // }
    //
    // socket.onerror = function (p1) {
    //     status.html(p1.message);
    // }
    //
    // $('form#test-form').on('submit', function (event) {
    //     var message = {
    //         "title": $('input#title').val(),
    //         "content": $('input#content').val()
    //     }
    //     socket.send(JSON.stringify(message));
    //     return false;
    // })

    // Pusher.logToConsole = true;
    //
    // var pusher = new Pusher('9d329e4ffa4a8363a7d5', {
    //     cluster: 'eu',
    //     encrypted: true
    // });
    //
    // var channel = pusher.subscribe('chat-room');
    // channel.bind('Message', function(data) {
    //     console.log("a");
    //     alert(JSON.stringify(data));
    //
    // });

    $('.send_message').on('click', function () {
        data = {
            title: $('#title').val(),
            message: $('#content').val()
        };
        $.ajax({
            method: "POST",
            url: '?route=message/send',
            data: data,
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        })
    });
    Pusher.logToConsole = true;

    var pusher = new Pusher('9d329e4ffa4a8363a7d5', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('chat-room');
    channel.bind('Message', function(data) {
        console.log(data);
        $('.result').append(data.message);
    });

})

