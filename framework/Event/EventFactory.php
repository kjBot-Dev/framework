<?php
namespace kjBot\Framework\Event;

class EventFactory{

    public static function createEventFrom($obj){
        switch($obj->post_type){
            case 'message':
                return new MessageEvent($obj);
            default:
                q("Event {$obj->post_type} undefined");
        }
    }

    private static function createEventFromPostData(){

    }

    private static function createEventFromRawPostData(){

    }
}