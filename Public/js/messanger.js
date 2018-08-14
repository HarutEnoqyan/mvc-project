$(document).ready(function () {
    window.setTimeout(function () {
        $('#messanger-partners div.messenger-item:first-child').trigger('click');
    },500);
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
        myID:0,


        /*
         * generating Messenger Block
         */
        generateMessangerBlock: function (event) {
            this.partner_id = $(event).attr('data-id');
            this.getMyId();
            $(event).parent('div').find('div.row').css('background', '#f5f1e8');

            //noinspection JSValidateTypes
            $(event).children('div.row').css('background', '#969292');

            let id = $(event).attr('data-id');

            let $data = {
                "id": id
            };

            $.ajax({
                url: "/message/ShowMessages",
                type: 'GET',
                data: $data,
                success: function (result) {
                    $data = JSON.parse(result);
                    let mainBlock = $('<div  id="mainBlock"></div>') , mainDiv =  $('div.messages');

                    $.each($data, function (index, value) {
                        if( 'seen' !== index  ){
                            let sent_by = value['sent_by'];
                            $('input.send_message').attr('data-id', value.partner_id);
                            $('input[name="message_text"]').attr('data-id', value.partner_id);
                            $('.message-input').css('display', 'block');

                            let div, img, span, $p ,imagePath;

                            if (sent_by === id) {

                                div = $('<div class="col-md-12 "></div>');
                                imagePath = value['partner_avatar'];
                                if (imagePath !== '') {
                                    img = $('<div class = "m-avatar"><img src="/images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                                } else {
                                    imagePath = 'default-profile.jpg';
                                    img = $('<div class = "m-avatar"><img src="/images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
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
                                    img = $('<div class = "m-avatar"><img src="/images/' + imagePath + '" alt="" class="message-author-avatar"></div>')
                                } else {
                                    img = $('<div class = "m-avatar"><img src="/images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
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

                    // noinspection JSCheckFunctionSignatures
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
                    url: '/message/send',
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
                    url: '/message/send',
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
                    img = $('<div class = "m-avatar"><img src="/images/ ' + imagePath + ' " alt="" class="message-author-avatar"></div>')
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
                    img = $('<div class = "m-avatar"><img src= "/images/uploads/' + imagePath + '" alt="" class="message-author-avatar"></div>')
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
            if (data['id']===messanger.partner_id && data['partner_id']===messanger.myID) {
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
                url: '/message/check',
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
                url: '/message/checkIfSeen',
                data: {'partner_id' : messanger.partner_id},
                success: function (data) {

                },
                error: function () {
                    alert('can\'t send message');
                }
            });


            $.ajax({
                method: "POST",
                url: '/message/setAllSeen',
                success: function () {
                    $('#messangerLink').find('span').css('display', 'none').html("");
                },
                error: function () {
                }
            })
        },


        /*
         * getiId
         */
        getMyId: function () {
            $.ajax({
                method: "POST",
                url: '/user/TakeId',
                success: function (data) {
                    messanger.myID = data;
                },
                error: function () {
                }
            })
        },

        /**
         * hide typing animation
         */


        hideTypingAnimation : function () {
            if (this.prevTimeout) {
                window.clearTimeout(this.prevTimeout);
            }
            this.prevTimeout = window.setTimeout(function () {
                $('.messages').find('#typing-gif').remove();

            }, 5000);
        },

        typing : function (data) {
            if (data !== messanger.partner_id) {
            } else {
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




    $('.messenger-item').on('click',function () {
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


        if(data['id_from'] === messanger.myID){
            $('.messages').find('#typing-gif').remove();

            messanger.showSentMessage(data);
        }
        else {
            $('.messages').find('#typing-gif').remove();

            if (data['id_from'] === messanger.partner_id && data['id_to'] === messanger.myID) {
                messanger.showReceivedMessage(data)
            }
            messanger.notify();
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
                data: {'id':messanger.myID},
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
