$(document).ready(function () {
    var input_id = '',
        comment = '',
        post_id = 0;
    $(document).on('click','.ajax_button', function (event) {
        input_id = $(this).attr('data-id');
        post_id = $(this).attr('data-post-id')
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

    function getVal(id) {
        comment = $('input#' + id).val();
        $('input#' + id).val('');
        // consolelog([post_id,comment]);
        // consolelog([post_id,comment]);

    }


});