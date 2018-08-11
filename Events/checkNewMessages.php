<?php
namespace Events;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/10/2018
 * Time: 3:20 PM
 */

namespace Events;
use Core\pusherInit;

class checkNewMessages extends pusherInit
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
        return 'checkNewMessages';
    }

    protected function getData()
    {
        return $this->data;
    }
}