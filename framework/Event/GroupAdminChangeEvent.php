<?php
namespace kjBot\Framework\Event;

class GroupAdminChangeEvent extends NoticeEvent{
    use GroupEvent;
    public function __construct($obj){
        parent::__construct($obj);
        $this->groupId = $obj->group_id;
    }
}
