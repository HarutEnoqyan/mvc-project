$(document).ready(function () {
    var input_id = '',
        comment = '',
        post_id = 0;
    $(document).on('click','.ajax_button', function (event) {
        input_id = $(this).attr('data-id');
        post_id = $(this).attr('data-post-id');
        count = $("button[data-target='#Collapse'+input_id] > span");
        getVal(input_id);

        $.ajax({

            url: '?route=comment/create',
            type: 'POST',
            data: 'post_id='+post_id+'&comment='+comment,
            success: function(result){
                result = JSON.parse(result);
                $('div#comment'+post_id).append(result);

            }

        });


    });

    $(document).on('keydown','.ajax_input', function (event) {
       if (event.keyCode===13){
           post_id = $(this).attr('data-post-id');
           comment = $(this).val();

           $.ajax({

               url: '?route=comment/create',
               type: 'POST',
               data: 'post_id='+post_id+'&comment='+comment,
               success: function(result){
                   result = JSON.parse(result);
                   $('div#comment'+post_id).append(result);

               }

           });
           $(this).val(' ');
       }


    });

    $(document).on('click','.ajax_reply_button', function (event) {
        input_id = $(this).attr('data-id');
        comment_id = $(this).attr('data-comment-id');
        comment = $('input#'+input_id).val();

        $.ajax({

            url: '?route=replyes/create',
            type: 'POST',
            data: 'comment_id='+comment_id+'&content='+comment,
            success: function(result){
                console.log(result);
                $('div#rep'+comment_id).append(result);


            }

        });

        $('input#'+input_id).val('');


    });

    $(document).on('keydown','.ajax_reply_input', function (event) {
        if (event.keyCode===13){
            comment_id = $(this).attr('data-comment-id');
            comment = $(this).val();

            $.ajax({

                url: '?route=replyes/create',
                type: 'POST',
                data: 'comment_id='+comment_id+'&content='+comment,
                success: function(result){
                    console.log(result);
                    $('div#rep'+comment_id).append(result);


                }

            });
            $(this).val(' ');
        }


    });


    function getVal(id) {
        comment = $('input#' + id).val();
        $('input#' + id).val('');

    }

    //................
    //image upload
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });
    //image upload end


});