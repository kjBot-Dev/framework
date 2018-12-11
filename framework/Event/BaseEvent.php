<?php
namespace kjBot\Framework\Event;

class BaseEvent{

    public $postType;
    public $time;
    protected $userId;
    private $selfId;

    protected $groupId;

    public function __construct($obj){
        if(is_object($obj)){
            $this->postType = $obj->post_type;
            $this->time = $obj->time;
            $this->userId = $obj->user_id;
            $this->selfId = $obj->self_id;
            $this->groupId = $obj->group_id??NULL;
        }else{
            q("Can't create Event from ".$obj);
        }
    }

    //来自自己的事件被用于触发定时任务
    public function isSelfEvent(){
        return $this->userId == $this->selfId;
    }

    public function getId(){
        return $this->userId;
    }

    public function getGroupId(){
        return $this->groupId;
    }
}
