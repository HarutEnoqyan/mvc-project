<?php
namespace App\Models;
use Core\ORM;
use Core\Auth;

class Friend extends ORM {
    public function __construct()
    {
        $this->table = 'friends';
    }

    public static function initFriendsId()
    {
        $friendsId = [];
        $data = new Friend();
        $data = $data->where("((user_id_1 = ".Auth::getId().") or(user_id_2 = ".Auth::getId().")) and (status=1)")->get();
        foreach ($data as $row) {
            if($row->attributes['user_id_1'] !== Auth::getId()){
                $friendsId[] = $row->attributes['user_id_1'];
            }else {
                $friendsId[]= $row->attributes['user_id_2'];
            }
        }
        return $friendsId;
    }

    public static function initRequests()
    {
        if(Auth::getId()!==null && Auth::getId() > 0) {
            $requestsId = [];
            $data = new Friend();
            $data = $data->select('request_from')->where("((user_id_1 = ".Auth::getId().") or(user_id_2 = ".Auth::getId().")) and (status=0) and (request_from!=".Auth::getId().")")->get();
            foreach ($data as $row) {
                $requestsId[] = $row->attributes['request_from'];
            }


            return $requestsId;
        }

    }

    public static function deleteFriend($id)
    {
        $data = new Friend();
        $data->where("((user_id_1 = ".Auth::getId().") or(user_id_2 = ".Auth::getId()."))and (request_from=".$id.")")->delete();
    }

    public static function accept($id)
    {
        $data = new Friend();
        $data ->where("request_from = $id")
            ->set(['status'], [1])
            ->update();
    }

    public static function decline($id)
    {
        $data = new Friend();
        $data->where("request_from = $id")->delete();
    }

    public static function getSentRequests()
    {
        $array = [];
        $data = new Friend();
        $data = $data->select('user_id_2')->where("user_id_1 = ".Auth::getId()."  and (status=0) and (request_from=".Auth::getId().")")->get();
        foreach ($data as $row) {
            $array[] = $row->attributes['user_id_2'];
        }
        return $array;
    }
}