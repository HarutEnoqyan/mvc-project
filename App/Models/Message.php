<?php

namespace App\Models;
use Core\ORM;
use Core\Auth;
use Events\SeenMessage;

class message extends ORM
{
    public function __construct()
    {
        $this->table = 'messages';
    }

    public static function getNewMessages ()
    {
        $count = 0;
        $messages = new message();
         $a =  $messages->where("id_to=".Auth::getId()." and seen!=1 ")->get();
         for ($i = 0 ; $i < count($a) ; $i++) {
            $count++;
        }
        return $count;
    }


    public static function getConversation($partnerid)
    {
        $messages = new Message();
        $selects = array(
            'messages.id AS message_id,
            messages.message AS message_content,
            messages.created_at AS message_created_at,
            message_sender.id AS sender_id,
            message_receiver.id AS receiver_id,
            message_sender.avatar AS sender_avatar,
            message_receiver.avatar AS receiver_avatar,
            CONCAT(message_sender.first_name ," ",message_sender.last_name) as sender,
            CONCAT(message_receiver.first_name ," ",message_receiver.last_name) as receiver'
        );

        $data =  $messages->select(implode(',' , $selects))
            ->where('id_from='.Auth::getId().' or id_to='.Auth::getId().'')
            ->order('message_created_at asc')
            ->join('users as message_sender' , 'messages.id_from' ,'=','message_sender.id')
            ->doubleJoin('users as message_receiver' , 'messages.id_to' ,'=','message_receiver.id')->toArray();

//        dd($data);
        $convarsation = [];
        foreach ($data as $val) {
            $id = Auth::getId();
            $arr = [];

            if ($val['sender_id']==$id){
                $arr['partner_id'] = $val['receiver_id'];
                $arr['sent_by'] = $id;
                $arr['partner_name'] = $val ['receiver'];
                $arr['partner_avatar'] = $val['receiver_avatar'];
                $arr['my_avatar'] = $val['sender_avatar'];
                $arr['message']  =$val['message_content'];
                $arr['created_at'] = $val['message_created_at'];
            }
            if ($val['receiver_id']==$id) {
                $arr['partner_id'] = $val['sender_id'];
                $arr['sent_by'] = $val['sender_id'];
                $arr['partner_name'] = $val['sender'];
                $arr['my_avatar'] = $val['receiver_avatar'];
                $arr['partner_avatar'] = $val['sender_avatar'];
                $arr['message']  =$val['message_content'];
                $arr['created_at'] = $val['message_created_at'];
            }
            $convarsation[$arr['partner_id']][] = $arr;
            $convarsation[$arr['partner_id']]['seen'] = static::checkSentMessage();;
        }
        return $convarsation[$partnerid];
    }

    public static function setMyMessagesAsSeen()
    {
        $m = new message();
        $m->where("id_to=".Auth::getId()." and seen!=1")->set(['seen'],[1])->update();

    }

    public static function checkSentMessage()
    {
        $count=0;
        $messages = new message();
        $partner_id = $_REQUEST['id'];
        $a = $messages->where("id_from=".Auth::getId()." and id_to=".$partner_id." and seen=0")->get();
        for ($i = 0 ; $i < count($a) ; $i++) {
            $count++;
        }
        return $count;
    }


}