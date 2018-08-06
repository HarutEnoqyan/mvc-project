<?php
 namespace App\Models;
 use Core\Auth;
 use Core\ORM;
 use App\Models\Friend as Friends;

 class User  extends ORM {
     protected $table = 'users';
     public static function InitFriends ()
     {
         $friends = [];
         $ids = Friends::initFriendsId();
         if (count($ids) > 0) {
             $ids = implode("," ,Friends::initFriendsId());
             $users = new User();
             $a =  $users -> where("id in ($ids)")->get();
             foreach ($a as $friend ) {
                 $friend = $friend->attributes;
                 $fr = [];
                 $fr['friend_id'] = $friend['id'];
                 $fr['name'] = $friend['first_name'] . ' ' . $friend['last_name'];
                 $fr['avatar'] = $friend['avatar'];
                 $fr['email'] = $friend['email'];
                 $friends[] = $fr;
             }
             return $friends;
         }else {
             return 'You haven\'t any friends';
         }

     }

     public static function initRequesters()
     {
        if(Auth::getId()!==null && Auth::getId()>0) {
            $friends = [];
            $count = 0;
            $ids = Friends::initRequests();
            if(count($ids)>0){
                $ids = implode("," ,Friends::initRequests());
                $users = new User();
                $a =  $users -> where("id in ($ids)")->get();
                foreach ($a as $friend ) {
                    $count++;
                    $friend = $friend->attributes;
                    $fr = [];
                    $fr['friend_id'] = $friend['id'];
                    $fr['name'] = $friend['first_name'] . ' ' . $friend['last_name'];
                    $fr['avatar'] = $friend['avatar'];
                    $fr['email'] = $friend['email'];
                    $friends[] = $fr;
                }
                $friends['count'] = $count;
                return $friends;
            } else {
                return 'You haven\'t any requests';
            }
        }

     }

 }
