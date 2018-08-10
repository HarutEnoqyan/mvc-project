<?php
namespace Events;

/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/10/2018
 * Time: 3:20 PM
 */

namespace Events;


class checkNewMessages extends \Core\pusherInit
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->init();
    }

    protected function getChanel()
    {
        return 'checkNewMessages';
    }

    protected function getEvent()
    {
        return 'status';
    }

    protected function getData()
    {
        return $this->data;
    }
}