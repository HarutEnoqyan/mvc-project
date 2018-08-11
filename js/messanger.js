$(document).ready(function () {

    Pusher.logToConsole = true;


    var pusher = new Pusher('9d329e4ffa4a8363a7d5', {
        cluster: 'eu',
        encrypted: true
    });

    var channel = pusher.subscribe('chat-room');

    var messanger = {
        partner_id : '',
        /*
         * generating Messanger Block
         */
        generateMessangerBlock : function (event) {
            this.partner_id = $(event).attr('data-id');
            $(event).parent('div').find('div.row').css('background','#f5f1e8')
            $(event).children('div.row').css('background','#969292');

            $seen = 0;

            $.ajax({
                method: "POST",
                url: '?route=message/SentMessage',
                success: function (data) {
                    $seen = data
                },
                error: function (data) {
                    console.log("chekav");
                }
            })

            var id = $(event).attr('data-id');
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
                            span = $('<span class="recived-message bg-primary text-light p-1"><xmp>'+value.message+'</xmp></span>');
                            $p = $('<p class="created-at"><small>'+value.created_at+'</small></p>');
                            div.append(img).append(span).append($p);
                            mainBlock.append(div)
                            mainBlock.find('.showIfSeen').remove();
                        } else {
                            div = $('<div class="col-md-12 text-right"></div>');
                            imagePath = value.my_avatar;
                            if(imagePath ==='') {
                                imagePath = 'default-profile.jpg';
                                img = $('<div class = "m-avatar"><img src="images/'+imagePath+'" alt="" class="message-author-avatar"></div>')
                            } else {
                                img = $('<div class = "m-avatar"><img src="images/uploads/'+imagePath+'" alt="" class="message-author-avatar"></div>')
                            }
                            span = $('<span class="my-message bg-primary text-light p-1"><xmp>'+value.message+'</xmp></span>');
                            $p = $('<p class="created-at"><small>'+value.created_at+'</small></p>');
                            div.append(span).append(img).append($p);
                            mainBlock.find('.showIfSeen').remove();
                            mainBlock.append(div)
                            if($seen>0){
                                mainBlock.append().append('<span class="showIfSeen"></span>')
                            } else {
                                mainBlock.append().append('<span class="showIfSeen">seen</span>')
                            }

                        }
                    })
                    $('div.messages').html(mainBlock);
                    height = document.getElementById("mainBlock").scrollHeight;
                    $('#mainBlock').animate({ scrollTop: height}, 0);
                }
            })
        },

        /*
         * Sending message on button click, geting params from button
         */
        sendMessageOnClick : function (event) {
            $id = $(event).attr('data-id');
            $sms = $(event).closest('.message-input').find('input[name="message_text"]').val();

            if($sms.trim() !==" " && $sms.trim() !=="" ) {
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove()

                data = {
                    "id": $id,
                    "message": $sms
                };
                $.ajax({
                    method: "POST",
                    url: '?route=message/send',
                    data: data,
                    success: function (data) {

                    },
                    error: function (data) {
                        alert('can\'t send message');
                    }
                })
                $(event).closest('.message-input').find('input[name="message_text"]').val('');
            }
        },

        /*
         * Sending message on input keydown, getting params from input
         */
        sendMessageOnKeyDown : function (event) {
            $id = $(event).attr('data-id');
            $sms = $(event).val();
            if($sms.trim() !==" " && $sms.trim() !==""){
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove()
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
                $(event).val('');
            }
        },

        /*
         * appending sent message to messager block
         */
        showSentMessage : function (data) {
            $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove();
            div = $('<div class="col-md-12 text-right"></div>');
            imagePath = data.avatar;
            if(imagePath ==='default-profile.jpg') {
                img = $('<div class = "m-avatar"><img src="images/'+imagePath+'" alt="" class="message-author-avatar"></div>')
            } else {
                img = $('<div class = "m-avatar"><img src="images/uploads/'+imagePath+'" alt="" class="message-author-avatar"></div>')
            }
            span = $('<span class="my-message bg-primary text-light p-1"><xmp>'+data.message+'</xmp></span>');
            $p = $('<p class="created-at"><small>'+data.created_at+'</small></p>');
            div.append(span).append(img).append($p);
            var block = document.getElementById("mainBlock");
            if(block !== null) {
                height = document.getElementById("mainBlock").scrollHeight;
                $('#mainBlock').animate({ scrollTop: height}, 500);
            }
            mainBlock = $('#mainBlock');
            mainBlock.append(div);
            mainBlock.append('<span class="showIfSeen"></span>');
        },

        /*
         * appending received message to messanger block
         */
        showReceivedMessage : function(data){
            if (data.id_from === this.partner_id) {
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove();
                div = $('<div class="col-md-12"></div>');
                imagePath = data.avatar;
                if (imagePath === 'default-profile.jpg') {
                    img = $('<div class = "m-avatar"><img src="images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                } else {
                    img = $('<div class = "m-avatar"><img src="images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                }
                span = $('<span class="recived-message bg-primary text-light p-1"><xmp>' + data.message + '</xmp></span>');
                $p = $('<p class="created-at"><small>' + data.created_at + '</small></p>');
                div.append(img).append(span).append($p);
                var block = document.getElementById("mainBlock");
                if (block !== null) {
                    height = document.getElementById("mainBlock").scrollHeight;
                    $('#mainBlock').animate({scrollTop: height}, 500);
                }
                mainBlock.append(div);
            }
            this.notify();
        },

        /*
         * checking if message seen
         */
        checkNewMessages: function (data) {

            if(data['id']!==messanger.getCookie('id')) {
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').html('seen');
            }

            var block = document.getElementById("mainBlock");
            if(block !== null) {
                height = document.getElementById("mainBlock").scrollHeight;
                $('#mainBlock').animate({ scrollTop: height}, 500);
            }

        },

        /*
         * notifying about new messages
         */
        notify : function () {
            $.ajax({
                method: "POST",
                url: '?route=message/check',
                success: function (data) {
                    if ( data && data >0) {

                        $('#messangerLink span').css('display','block').html(data);
                    }
                },
                error: function (data) {
                    console.log("chekav");
                }
            })
        },

        /*
         * realtime checkinf if seen and seting all seen in db
         */
        checkAndSetAllSeen : function () {
            $.ajax({
                method: "POST",
                url: '?route=message/checkIfSeen',
                success: function (data) {

                },
                error: function (data) {
                    alert('can\'t send message');
                }
            })


            $.ajax({
                method: "POST",
                url: '?route=message/setAllSeen',
                success: function (data) {
                    $('#messangerLink span').css('display','none').html("");
                },
                error: function (data) {
                }
            })
        },


        /*
         * geting data from cookie
         */
        getCookie : function (cname) {
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
        },

        /*
         * for seting data in cookie
         */
        setCookie : function (cname, cvalue) {
            document.cookie = cname + "=" + cvalue + ";" ;
        }


    }



    $('.messenger-item').on('click', function () {
       messanger.generateMessangerBlock(this);
    });


    $(document).on('click','.send_message', function () {
        messanger.sendMessageOnClick(this);
    });

    $(document).on('keyup','input[name="message_text"]' , function (event) {
        if (event.which===13) {
            messanger.sendMessageOnKeyDown($(this))
        }
    });

    channel.bind('Message', function(data) {
        my_id = messanger.getCookie('id');
        mainBlock = $('#mainBlock');
        if(data.id_from === my_id){
           messanger.showSentMessage(data);
        }
        else {
            messanger.showReceivedMessage(data)
        }
    });


    channel.bind('checkNewMessages',function (data) {
        messanger.checkNewMessages(data);
    })

    $(document).on('click','div.message-input input#content', function (ev) {
        messanger.checkAndSetAllSeen();
    })


})

