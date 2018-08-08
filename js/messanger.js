$(document).ready(function () {

    $('.messenger-item').on('click', function () {
        var id = $(this).attr('data-id');
        $data = {
            "id" : id
        }
        $.ajax({
            url : "?route=message/ShowMessages",
            type:'GET',
            data:$data,
            success: function (result) {
                $data = JSON.parse(result);
                mainBlock = $('<div id="mainBlock"></div>');


                $.each($data , function (index, value) {

                    $('input.send_message').attr('data-id' , value.partner_id);
                    $('input[name="message_text"]').attr('data-id' , value.partner_id);
                    $('.message-input').css('display','block');

                    if (value.sent_by===id) {
                        div = $('<div class="col-md-12 "></div>');
                        imagePath = value.partner_avatar;
                        if(imagePath ==='' ) {
                            imagePath = 'default-profile.jpg';
                            img = $('<div class = "m-avatar"><img src="images/'+imagePath+'" alt="" class="message-author-avatar"></div>')
                        } else {
                            img = $('<div class = "m-avatar"><img src="images/uploads/'+imagePath+'" alt="" class="message-author-avatar"></div>')
                        }
                        span = $('<span class="recived-message bg-primary text-light p-1">'+value.message+'</span>');
                        $p = $('<p class="created-at"><small>'+value.created_at+'</small></p>');
                        div.append(img).append(span).append($p);
                        mainBlock.append(div)
                    } else {
                        div = $('<div class="col-md-12 text-right"></div>');
                        imagePath = value.my_avatar;
                        if(imagePath ==='') {
                            imagePath = 'default-profile.jpg';
                            img = $('<div class = "m-avatar"><img src="images/'+imagePath+'" alt="" class="message-author-avatar"></div>')
                        } else {
                            img = $('<div class = "m-avatar"><img src="images/uploads/'+imagePath+'" alt="" class="message-author-avatar"></div>')
                        }
                        span = $('<span class="my-message bg-primary text-light p-1">'+value.message+'</span>');
                        $p = $('<p class="created-at"><small>'+value.created_at+'</small></p>');
                        div.append(span).append(img).append($p);
                        mainBlock.append(div)
                    }
                })
                $('div.messages').html(mainBlock);
                height = document.getElementById("mainBlock").scrollHeight;
                $('#mainBlock').animate({ scrollTop: height}, 500);
            }
        })
    })


    $(document).on('click','.send_message', function () {

        $id = $(this).attr('data-id');
        $sms = $(this).closest('.message-input').find('input[name="message_text"]').val();
        if($sms.trim() !==" " && $sms.trim() !=="" ) {
            data = {
                "id": $id,
                "message": $sms
            };
            $.ajax({
                method: "POST",
                url: '?route=message/send',
                data: data,
                success: function (data) {
                    console.log($sms);
                },
                error: function (data) {
                    console.log(data);
                }
            })
            $(this).closest('.message-input').find('input[name="message_text"]').val('');
        }
    });

    $(document).on('keyup','input[name="message_text"]' , function (event) {
        if(event.which ===13) {

            $id = $(this).attr('data-id');
            $sms = $(this).val();
            if($sms.trim() !==" " && $sms.trim() !==""){
                data = {
                    "id" : $id,
                    "message" : $sms
                };
                $.ajax({
                    method: "POST",
                    url: '?route=message/send',
                    data: data,
                    success: function (data) {
                        console.log("sent");
                    },
                    error: function (data) {
                        console.log(data);
                    }
                })
                $(this).val('');
            }
         }
    })

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    Pusher.logToConsole = true;

    var pusher = new Pusher('9d329e4ffa4a8363a7d5', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('chat-room');
    channel.bind('Message', function(data) {
        my_id = getCookie('id');
        if(data.id_from ===my_id){
            div = $('<div class="col-md-12 text-right"></div>');
            imagePath = data.avatar;
            if(imagePath ==='default-profile.jpg') {
                img = $('<div class = "m-avatar"><img src="images/'+imagePath+'" alt="" class="message-author-avatar"></div>')
            } else {
                img = $('<div class = "m-avatar"><img src="images/uploads/'+imagePath+'" alt="" class="message-author-avatar"></div>')
            }
            span = $('<span class="my-message bg-primary text-light p-1">'+data.message+'</span>');
            $p = $('<p class="created-at"><small>'+data.created_at+'</small></p>');
            div.append(span).append(img).append($p);
            height = document.getElementById("mainBlock").scrollHeight;
            $('#mainBlock').animate({ scrollTop: height}, 500);

        }
        else {
            div = $('<div class="col-md-12"></div>');
            imagePath = data.avatar;
            if(imagePath ==='default-profile.jpg') {
                img = $('<div class = "m-avatar"><img src="images/'+imagePath+'" alt="" class="message-author-avatar"></div>')
            } else {
                img = $('<div class = "m-avatar"><img src="images/uploads/'+imagePath+'" alt="" class="message-author-avatar"></div>')
            }
            span = $('<span class="recived-message bg-primary text-light p-1">'+data.message+'</span>');
            $p = $('<p class="created-at"><small>'+data.created_at+'</small></p>');
            div.append(img).append(span).append($p);
            height = document.getElementById("mainBlock").scrollHeight;
            $('#mainBlock').animate({ scrollTop: height}, 500);
        }


        $('#mainBlock').append(div);
    });


})

