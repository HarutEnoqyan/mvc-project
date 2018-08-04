$(document).ready(function () {
    var input_id = '',
        comment = '',
        post_id = 0;
    $(document).on('click','.ajax_button', function () {
        input_id = $(this).attr('data-id');
        post_id = $(this).attr('data-post-id');
        count = $('button [ data-target="#Collapse"+ input_id ] > span');
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

    var upload = {
        fileNames : [],
        namesInput : '',
        imagesInput : document.getElementById("imgInp"),
        files : [],
        btn : '',
        txt : '',
        formData : new FormData(),


        getFileNames : function (input) {
            file = this.imagesInput.files;

            for (var i = 0; i<file.length; i++){
                if ($.inArray(file[i] , this.files) === -1){
                    this.files.push(file[i]);
                }
                if ($.inArray(file[i]['name'] , this.fileNames) === -1){
                    this.fileNames.push(file[i]['name']);

                }
            }

            input.trigger('fileselect',this.fileNames.toString());

        },

        readURL : function (input) {
            if (input.files) {
                var div =  $('div.upload-image-group');
                $.each(input.files, function (key, val) {

                    var file = val;
                    var reader = new FileReader();
                    name = file['name'];
                    id = file['lastModified'];
                    reader.readAsDataURL(val);
                    reader.onload = function (e) {
                        upload.btn = "<span data-name='"+file['name']+"' class='btn  btn-danger image_remove absolute' data-id='"+file['lastModified']+"'>x<span> ";
                        upload.txt = '<div class="upload_image col-md-2 relative"> <img data-id="'+file['lastModified']+'" class="uploaded_image" alt="uploaded-image" src=' +'"'+ e.target.result +'"'+ '</img>'+upload.btn+"</div>" ;
                        div.append(upload.txt);

                    };
                });
            }
        },

        removeIMG : function (data) {
            var name = data.attr('data-name');
            data.parent('div').remove();
            for (var i = 0; i < this.fileNames.length ; i++) {
                if (this.fileNames[i] === name){
                    this.fileNames.splice(i,1);
                }
                if (this.files[i]['name']===name) {
                    this.files.splice(i,1);
                }
            }
            this.namesInput.val(this.fileNames.toString())
        },

        initFileList : function () {
            for (var i = 0 ; i < this.files.length ; i ++) {
                this.formData.append('images[]', this.files[i]);
            }

            // for (var pair of upload.formData.entries()) {
            //     console.log(pair[0]+ ', ' + pair[1]);
            // }
        }


    };




    $(document).on('change', '.btn-file :file', function() {
        var input = $(this);
        upload.getFileNames(input);

    });

    $('.btn-file :file').on('fileselect', function(event, label) {
        upload.namesInput = $(this).parents('.input-group').find(':text');
        if( upload.namesInput.length ) {
            upload.namesInput.val(label);
        } else {
            if( log ) alert(log);
        }
    });

    $("#imgInp").change(function(){
        upload.readURL(this);
    });
    $(document).on('click','span.image_remove', function () {
        var btn = $(this);
        upload.removeIMG(btn);
    })



    $(document).on('click','#post-create-btn', function () {
        var  title = $('#title').val(),
            content= $('#content').val();
        upload.initFileList();
        upload.formData.append('title' , title);
        upload.formData.append('content' , content);

        $.ajax({

            url: '?route=post/save',
            type: 'POST',
            data: upload.formData,
            processData: false,
            contentType: false,
            success: function(result){
                result = JSON.parse(result);
                $('.error-message').remove();
                $('.is-invalid').removeClass('is-invalid');
                if (result.errors) {
                    $.each(result.errors, function (key, value) {
                        $('input[name="'+key+'"]').after('<span class="text-danger error-message">'+value+'</span>').addClass('is-invalid');
                        $('textarea[name="'+key+'"]').after('<span class="text-danger error-message">'+value+'</span>').addClass('is-invalid');
                    })
                }else {
                    window.location.href = '?route=post/index';

                }


            }

        });
    });
    //image upload end

    $(document).on('click','#post-edit-btn', function () {
        id = $(this).attr('data-id');
        upload.formData.append('id' , id);
        upload.initFileList();


        $.ajax({

            url: '?route=post/thumbnail_update',
            type: 'POST',
            data: upload.formData,
            processData: false,
            contentType: false,
            success: function(result){
                // for (var pair of upload.formData.entries()) {
                //     console.log(pair[0]+ ', ' + pair[1]);
                // }
                    window.location.href = '?route=post/index';




            }

        });
    });

});