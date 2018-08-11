<?php

namespace Events;
use Core\pusherInit;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/7/2018
 * Time: 2:03 PM
 */
class Message extends pusherInit
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->init();
    }

    protected function getChanel()
    {
        return 'chat-room';
    }

    protected function getEvent()
    {
        return 'Message';
    }

    protected function getData()
    {
        return $this->data;
    }
}