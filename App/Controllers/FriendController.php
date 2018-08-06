<?php
namespace App\Controllers;
use App\Models\Friend as Friend;
use Core\Auth;
use App\Models\User as Users;
use function MongoDB\BSON\toJSON;

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



    public function actionShow()
    {
        $friends = Users::InitFriends();
        view('Friends/show', $friends);
    }

    public function actionShowRequests()
    {
        $users = Users::initRequesters();
        view('Friends/requests', $users);
    }

    public function actionAccept()
    {
        $id = $_REQUEST['id'];
        Friend::accept($id);
        redirect(route('friend/showRequests'));
    }

    public function actionDecline()
    {
        $id = $_REQUEST['id'];
        Friend::decline($id);
        redirect(route('friend/showRequests'));

    }

    public function actionDelete()
    {
        $id = $_REQUEST['id'];
        Friend::deleteFriend($id);
        redirect(route('friend/show'));
    }


}

