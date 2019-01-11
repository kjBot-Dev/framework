<?php
namespace kjBot\Framework\Event;

class GroupMemberChange extends NoticeEvent{
    use GroupEvent;
    public $operatorId;
    public function __construct($obj){
        parent::__construct($obj);
        $this->groupId = $obj->group_id;
        $this->operatorId = $obj->operator_id;
    }
}
