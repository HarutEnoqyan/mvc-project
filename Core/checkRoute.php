<?php
namespace Core;
use Core\Auth as Auth;

class checkRoute
{
    public static function check()
    {
        $publicLinks = array(
            'main/login',
            'main/register',
            'main/index',
            'main/errorPage',
            'main/login',
            'main/register'
        );

        $authList = array(
            'user/index',
            'user/show',
            'post/index',
            'post/create',
            'post/edit',
            'post/show',
            'post/save',
            'post/thumbnail_edit',
            'post/thumbnail_edit',
            'post/thumbnail_update',
            'friend/show',
            'friend/showRequests',
            'comment/create',
            'replyes/create',
            'main/test',
            'message/send',
            'message/show',
            'message/ShowMessages',
            'message/check',
            'message/setAllSeen',
            'message/checkIfSeen',
            'message/SentMessage',
            'message/isTyping',
            'user/TakeId'

        );


        if (!Auth::checkIfAuth() && $_SERVER['REQUEST_URI']){
            $route = substr(explode('?' ,$_SERVER['REQUEST_URI'])[0], 1);
            if (!in_array($route, $publicLinks)){
                return false;
            }
        }

        if (Auth::checkIfAuth() && $_SERVER['REQUEST_URI']){
            $route = substr(explode('?' ,$_SERVER['REQUEST_URI'])[0], 1);
            if (!in_array($route, $authList)){
                return false;
            }else{
                return true;
            }
        }
    }
}