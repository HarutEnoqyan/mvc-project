<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/11/2018
 * Time: 6:43 PM
 */

namespace Events;
use Core\pusherInit;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/7/2018
 * Time: 2:03 PM
 */

class isTyping extends pusherInit

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
        return 'isTyping';
    }

    protected function getData()
    {
        return $this->data;
    }
}