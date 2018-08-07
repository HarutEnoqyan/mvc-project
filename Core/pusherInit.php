<?php
namespace Core;
use Pusher;
abstract class pusherInit
{
    protected abstract function getChanel();
    protected abstract function getEvent();
    protected abstract function getData();

    protected function init(){
        $options = array(
            'cluster' => 'eu',
            'encrypted' => true
        );
        $pusher = new Pusher\Pusher(
            '9d329e4ffa4a8363a7d5',
            '7e8d3633e612e4b7bd6b',
            '573841',
            $options
        );

        $pusher->trigger($this->getChanel(), $this->getEvent(), $this->getData());
    }




}