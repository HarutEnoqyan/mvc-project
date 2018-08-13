$(document).ready(function () {
    Pusher.logToConsole = false;

    let pusher = new Pusher('9d329e4ffa4a8363a7d5', {
        cluster: 'eu',
        encrypted: true
    });
    let channel = pusher.subscribe('chat-room');
    let messanger;


    messanger = {
        partner_id: '',
        $seen:'',
        prevTimeout : 0,


        /*
         * generating Messenger Block
         */
        generateMessangerBlock: function (event) {
            this.partner_id = $(event).attr('data-id');

            $(event).parent('div').find('div.row').css('background', '#f5f1e8');

            //noinspection JSValidateTypes
            $(event).children('div.row').css('background', '#969292');

            let id = $(event).attr('data-id');

            let $data = {
                "id": id
            };

            $.ajax({
                url: "?route=message/ShowMessages",
                type: 'GET',
                data: $data,
                success: function (result) {
                    $data = JSON.parse(result);
                    let mainBlock = $('<div  id="mainBlock"></div>') , mainDiv =  $('div.messages');

                    $.each($data, function (index, value) {
                        if(index!=='seen'){
                            let sent_by = value['sent_by'];
                            $('input.send_message').attr('data-id', value.partner_id);
                            $('input[name="message_text"]').attr('data-id', value.partner_id);
                            $('.message-input').css('display', 'block');

                            let div, img, span, $p ,imagePath;

                            if (sent_by === id) {

                                div = $('<div class="col-md-12 "></div>');
                                imagePath = value['partner_avatar'];
                                if (imagePath !== '') {
                                    img = $('<div class = "m-avatar"><img src="images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                                } else {
                                    imagePath = 'default-profile.jpg';
                                    img = $('<div class = "m-avatar"><img src="images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                                }
                                span = $('<span class="recived-message bg-primary text-light p-1"><xmp>' + value.message + '</xmp></span>');
                                $p = $('<p class="created-at"><small>' + value['created_at'] + '</small></p>');
                                div.append(img).append(span).append($p);
                                mainBlock.append(div);
                                mainBlock.find('.showIfSeen').remove();
                            } else {
                                div = $('<div class="col-md-12 text-right"></div>');
                                imagePath = value['my_avatar'];

                                if (imagePath === '') {
                                    imagePath = 'default-profile.jpg';
                                    img = $('<div class = "m-avatar"><img src="images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                                } else {
                                    img = $('<div class = "m-avatar"><img src="images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                                }

                                span = $('<span class="my-message bg-primary text-light p-1"><xmp>' + value['message'] + '</xmp></span>');
                                $p = $('<p class="created-at"><small>' + value['created_at'] + '</small></p>');
                                div.append(span).append(img).append($p);
                                mainBlock.append(div);
                                mainBlock.find('.showIfSeen').remove();
                                if (parseInt($data['seen']) === 0) {
                                    mainBlock.append('<span class="showIfSeen">seen</span>')
                                }
                            }
                        }
                    });

                    mainDiv.html(mainBlock);

                    let height = document.getElementById("mainBlock").scrollHeight;
                    $('#mainBlock').animate({scrollTop: height}, 0);
                }
            })
        },

        /*
         * Sending message on button click, getting params from button
         */
        sendMessageOnClick : function (event) {
            let $id = $(event).attr('data-id');
            let $sms = $(event).closest('.message-input').find('input[name="message_text"]').val();

            if ($sms.trim() !== " " && $sms.trim() !== "") {
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove();

                let data = {
                    "id": $id,
                    "message": $sms
                };
                $.ajax({
                    method: "POST",
                    url: '?route=message/send',
                    data: data,
                    success: function (data) {
                    },
                    error: function () {
                        alert('can\'t send message');
                    }
                });
                $(event).closest('.message-input').find('input[name="message_text"]').val('');
            }
        },

        /*
         * Sending message on input key down, getting params from input
         */
        sendMessageOnKeyDown: function (event) {
            let $id = $(event).attr('data-id');
            let $sms;
            $sms = $(event).val();
            if ($sms.trim() !== " " && $sms.trim() !== "") {
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove();
                let data = {
                    "id": $id,
                    "message": $sms
                };
                $.ajax({
                    method: "POST",
                    url: '?route=message/send',
                    data: data,
                    success: function () {
                    },
                    error: function (data) {
                        // console.log(data);
                    }
                });
                $(event).val('');
            }
        },

        /*
         * appending sent message to messenger block
         */
        showSentMessage: function (data) {
            let span, $p,div,imagePath , img , height , mainBlock =  $('#mainBlock');
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove();
                div = $('<div class="col-md-12 text-right"></div>');
                imagePath = data['avatar'];
                if (imagePath === 'default-profile.jpg') {
                    img = $('<div class = "m-avatar"><img src="/images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                } else {
                    img = $('<div class = "m-avatar"><img src="/images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                }
                span = $('<span class="my-message bg-primary text-light p-1"><xmp>' + data['message'] + '</xmp></span>');
                $p = $('<p class="created-at"><small>' + data['created_at'] + '</small></p>');
                div.append(span).append(img).append($p);
                let block = document.getElementById("mainBlock");
                if (block !== null) {
                    height = document.getElementById("mainBlock").scrollHeight;
                    mainBlock.animate({scrollTop: height}, 500);
                }
                mainBlock.append(div);
                mainBlock.append('<span class="showIfSeen"></span>');

        },

        /*
         * appending received message to messenger block
         */
        showReceivedMessage: function (data) {
            let span, $p, div , imagePath , img , height , mainBlock =  $('#mainBlock');

                $('.messages').find('div#mainBlock:last-child span.showIfSeen').remove();
                div = $('<div class="col-md-12"></div>');
                imagePath = data['avatar'];
                if (imagePath === 'default-profile.jpg') {
                    img = $('<div class = "m-avatar"><img src="/images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                } else {
                    img = $('<div class = "m-avatar"><img src="/images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                }
                span = $('<span class="recived-message bg-primary text-light p-1"><xmp>' + data.message + '</xmp></span>');
                $p = $('<p class="created-at"><small>' + data['created_at'] + '</small></p>');
                div.append(img).append(span).append($p);
                let block = document.getElementById("mainBlock");
                if (block !== null) {
                    height = document.getElementById("mainBlock").scrollHeight;
                    mainBlock.animate({scrollTop: height}, 500);
                }
                mainBlock.append(div);

        },

        /*
         * checking if message seen
         */
        checkNewMessages: function (data) {
            let height;
            if (data['id']===messanger.partner_id && data['partner_id']===messanger.getCookie('id')) {
                $('.messages').find('div#mainBlock:last-child span.showIfSeen').html('seen');
            }

            let block = document.getElementById("mainBlock");
            if (block !== null) {
                height = document.getElementById("mainBlock").scrollHeight;
                $('#mainBlock').animate({scrollTop: height}, 500);
            }

        },

        /*
         * notifying about new messages
         */
        notify: function () {
            $.ajax({
                method: "POST",
                url: '?route=message/check',
                success: function (data) {
                    if (data && data > 0) {
                        $("#messangerLink").find("span").css('display', 'block').html(data);
                    }
                },
                error: function () {
                    console.log("chekav");
                }
            })
        },

        /*
         * real time checking if seen and seting all seen in db
         */
        checkAndSetAllSeen: function () {
            $.ajax({
                method: "POST",
                url: '?route=message/checkIfSeen',
                data: {'partner_id' : messanger.partner_id},
                success: function (data) {

                },
                error: function () {
                    alert('can\'t send message');
                }
            });


            $.ajax({
                method: "POST",
                url: '?route=message/setAllSeen',
                success: function () {
                    $('#messangerLink').find('span').css('display', 'none').html("");
                },
                error: function () {
                }
            })
        },


        /*
         * geting data from cookie
         */
        getCookie: function (cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) === 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },

        /*
         * for seting data in cookie
         */
        // setCookie: function (cname, cvalue) {
        //     document.cookie = cname + "=" + cvalue + ";";
        // }

        hideTypingAnimation : function () {
            if (this.prevTimeout) {
                window.clearTimeout(this.prevTimeout);
            }
            this.prevTimeout = window.setTimeout(function () {
                $('.messages').find('#typing-gif').remove();

            }, 5000);
        },

        typing : function (data) {
            if(data===messanger.partner_id){
                $('.messages').find('#typing-gif').remove();
                let gif = $('<img src="/images/typing.gif" id="typing-gif" alt="">');
                $('#mainBlock').append(gif);
                this.hideTypingAnimation();
            }

            let block = document.getElementById("mainBlock");
            if (block !== null) {
                let height = document.getElementById("mainBlock").scrollHeight;
                $('#mainBlock').animate({scrollTop: height}, 500);
            }
        }


    };

    console.log(messanger.getCookie("my_id"))

    //language=JQuery-CSS
    $('.messenger-item').click(function () {
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
        let my_id = messanger.getCookie('id');
        let mainBlock = $('#mainBlock');

        if(data['id_from'] === my_id){
           messanger.showSentMessage(data);
        }
        else {
            if (data['id_from'] === messanger.partner_id && data['id_to'] === my_id) {
                messanger.showReceivedMessage(data)
            }
        }
    });


    channel.bind('checkNewMessages',function (data) {
        messanger.checkNewMessages(data);
    });

    $(document).on('click','div.message-input input#content', function () {
        messanger.checkAndSetAllSeen();
    });


    channel.bind('isTyping',function (data) {
        messanger.typing(data);
    });


    let typing = false;
    $(document).on('keydown','div.message-input input#content', function () {
        if(typing===false) {
            typing=true;
            $.ajax({
                method: "POST",
                url: '/message/isTyping',
                data: {'id':messanger.getCookie('id')},
                success: function (data) {
                },
                error: function () {
                    alert('can\'t send message');
                }
            });
        }
        setTimeout(function () {
            typing = false
        },5000)

    });
});
