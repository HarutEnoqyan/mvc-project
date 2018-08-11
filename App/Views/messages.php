<div class="row
">
    <div class="col-md-3 ml-3 mr-1  border">
        <?php
        /** @var  $params */
        foreach($params as $key=> $conn) {?>
        <div class='col-md-12 messenger-item border  ' data-id="<?=$key?>">
            <div class="row">
                <div class="col-lg-4 col-md-6 messenger-item-avatar mt-1">
                    <img src="<?=$conn['avatar']!=="" && $conn['avatar']!==null? IMAGE_PATH."/".$conn['avatar']: "images/default-profile.jpg"?>" alt="">
                </div>
                <div class="col-lg-8 col-md-12">
                    <p class="name"><?=$conn['name']?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-8 border bg-light relative">

            <div class="messages mt-3  pt-2">
            </div>

        <div class="row col-md-12 message-input">
            <div class="col-8" style="display: inline-block">
                <input type="text" id="content" class="form-control" placeholder="Enter message" name="message_text">
            </div>
            <div class="col-md-1" style="display: inline-block">
                <input type="button" class="btn btn-primary send_message " value="Send" >
            </div>
        </div>

    </div>

</div>


