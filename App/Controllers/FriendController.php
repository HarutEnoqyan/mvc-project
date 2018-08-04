<?php
namespace App\Controllers;
use App\Models\Friend;
use Core\Auth;

class FriendController  {
    public function actionSendRequest()
    {
        $id = $_GET['id'];
        $request = new Friend();
        $request -> attributes['user_id_1'] = Auth::getId();
        $request ->attributes['user_id_2'] = $id;
        $request ->attributes['request_from'] = Auth::getId();
        $request -> attributes['created_at'] = date("Y-m-d H:i:s");
        $request->insert();
        redirect( route('user/show'));
    }

    public static function initFriends()
    {
        $friends = new Friend();
        $friends = $friends->where("(user_id_1 = ".Auth::getId().") or(user_id_2 = ".Auth::getId().")")->get();
        return $friends;
    }
}

