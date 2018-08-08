<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/7/2018
 * Time: 3:20 PM
 */
namespace App\Controllers;
use Events\Message as send;
use App\Models\Message;
use Core\Auth;

class MessageController
{
    public function actionSend()
    {
        if (!empty($_POST['message'])){
            $data['message'] = $_POST['message'];
            $data['id_from'] = Auth::getId();
            $data['created_at'] = date("Y-m-d H:i:s");
            if (session_id()==''){
                session_start();
            }
            if ($_SESSION['avatar']!==null && $_SESSION['avatar']!=="") {
                $data['avatar'] = $_SESSION['avatar'];
            } else {
                $data['avatar'] = 'default-profile.jpg';
            }
            $id = $_POST['id'];
            $sms = $_POST['message'];
            $a = new Message();
            $a->attributes['id_from']=Auth::getId();
            $a->attributes['id_to'] = $id;
            $a->attributes['message'] = $sms;
            $a->attributes['created_at'] = date("Y-m-d H:i:s");
            $a->insert();
            new send($data);
        }
    }

    public function actionShow()
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
                ->order('messages.created_at desc')
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
                $arr['message']  =$val['message_content'];
                $arr['created_at'] = $val['message_created_at'];
            }
            if ($val['receiver_id']==$id) {
                $arr['partner_id'] = $val['sender_id'];
                $arr['sent_by'] = $val['sender_id'];
                $arr['partner_name'] = $val['sender'];
                $arr['partner_avatar'] = $val['sender_avatar'];
                $arr['message']  =$val['message_content'];
                $arr['created_at'] = $val['message_created_at'];
            }
            $convarsation[$arr['partner_id']]['name'] = $arr['partner_name'];
            $convarsation[$arr['partner_id']]['avatar']=$arr['partner_avatar'];
            $convarsation[$arr['partner_id']]['messages'][] = $arr;
        }
//        dd($data);
//        dd($convarsation);

        view('messages',$convarsation);
    }

    public function actionShowMessages()
    {
        $id = $_GET['id'];
        echo json_encode(Message::getConversation($id));
    }


}