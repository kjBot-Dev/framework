<?php
namespace kjBot\Framework\Event;

use kjBot\Framework\Message;
use kjBot\Framework\TargetType;

class BaseEvent{

    public $postType;
    public $time;
    public $type;
    public $subType;
    protected $userId;
    private $selfId;

    protected $originalEvent;

    public function __construct($obj){
        if(is_object($obj)){
            $this->postType = $obj->post_type;
            try{
                $this->type = (new \ReflectionObject($obj))->getProperty($obj->post_type.'_type')->getValue($obj);
            }catch(\ReflectionException $e){
                $this->type = NULL;
                d("Can't reflect {$obj->post_type}: ".\export($obj));
            }
            $this->subType = $obj->sub_type??NULL;
            $this->time = $obj->time;
            @$this->userId = $obj->user_id;
            $this->selfId = $obj->self_id;
            $this->originalEvent = $obj;
        }else{
            q("Can't create Event from ".$obj);
        }
    }

    //来自自己的事件被用于触发定时任务
    public function isSelfEvent(){
        return $this->userId == $this->selfId;
    }

    public function getEvent(){
        return $this->originalEvent;
    }

    public function getId(){
        return $this->userId;
    }

    public function sendPrivate(?string $msg): Message{
        return new Message($msg, $this->userId, TargetType::Private);
    }

    public function sendBack(?string $msg): Message{
        if(@$this->groupId!==NULL)
        return new Message($msg, $this->groupId, TargetType::Group);
        else return $this->sendPrivate($msg);
    }

    public function sendTo(int $targetType, $target, $msg){
        return new Message($msg, $target, $targetType);
    }
}
