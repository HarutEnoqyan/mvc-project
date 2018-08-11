$(document).ready(function () {
    let input_id = '',
        comment = '',
        post_id = 0;
    $(document).on('click','.ajax_button', function () {
        input_id = $(this).attr('data-id');
        post_id = $(this).attr('data-post-id');
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

    $(document).on('click','.ajax_reply_button', function () {
        let input_id = $(this).attr('data-id');
        let comment_id = $(this).attr('data-comment-id');
        let input = $('input#'+input_id);
        let comment = input.val();

        $.ajax({

            url: '?route=replyes/create',
            type: 'POST',
            data: 'comment_id='+comment_id+'&content='+comment,
            success: function(result){
                $('div#rep'+comment_id).append(result);


            }

        });

        input.val('');


    });

    $(document).on('keydown','.ajax_reply_input', function (event) {
        if (event.keyCode===13){
            let comment_id = $(this).attr('data-comment-id');
            let comment = $(this).val();

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
        let input = $('input#' + id);
        comment = input.val();
        input.val('');

    }

    //................
    //image upload

    let upload = {
        fileNames : [],
        namesInput : '',
        imagesInput : document.getElementById("imgInp"),
        files : [],
        btn : '',
        txt : '',
        formData : new FormData(),


        getFileNames : function (input) {
            let file = this.imagesInput.files;

            for (let i = 0; i<file.length; i++){
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
                let div =  $('div.upload-image-group');
                $.each(input.files, function (key, val) {

                    let file = val;
                    let reader = new FileReader();
                    let name = file['name'];
                    let id = file['lastModified'];
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
            let name = data.attr('data-name');
            data.parent('div').remove();
            for (let i = 0; i < this.fileNames.length ; i++) {
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
            for (let i = 0 ; i < this.files.length ; i ++) {
                this.formData.append('images[]', this.files[i]);
            }

            // for (let pair of upload.formData.entries()) {
            //     console.log(pair[0]+ ', ' + pair[1]);
            // }
        }


    };




    $(document).on('change', '.btn-file :file', function() {
        let input = $(this);
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

    $("#imgInp").on('change', function(){
        upload.readURL(this);
    });
    $(document).on('click','span.image_remove', function () {
        let btn = $(this);
        upload.removeIMG(btn);
    });



    $(document).on('click','#post-create-btn', function () {
        let  title = $('#title').val(),
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
                if (result['errors']) {
                    $.each(result['errors'], function (key, value) {
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
        let id = $(this).attr('data-id');
        upload.formData.append('id' , id);
        upload.initFileList();


        $.ajax({

            url: '?route=post/thumbnail_update',
            type: 'POST',
            data: upload.formData,
            processData: false,
            contentType: false,
            success: function(){
                    window.location.href = '?route=post/index';
            }

        });
    });



});