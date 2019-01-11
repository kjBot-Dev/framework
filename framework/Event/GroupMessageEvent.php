<?php
namespace kjBot\Framework\Event;

class GroupMessageEvent extends MessageEvent{
    use GroupEvent;
    public function __construct($obj){
        parent::__construct($obj);
        $this->groupId = $obj->group_id;
    }
}
