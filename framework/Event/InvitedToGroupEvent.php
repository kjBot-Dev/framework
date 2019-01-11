<?php
namespace kjBot\Framework\Event;

use kjBot\SDK\CoolQ;

class InvitedToGroupEvent extends RequestEvent{
    use GroupEvent, RequestCommon;
    public function __construct($obj){
        parent::__construct($obj);
        $this->groupId = $obj->group_id;
        $this->comment = $obj->comment;
        $this->flag = $obj->flag;
    }

    public function accept(CoolQ $cq){
        return $cq->setGroupAddRequest($this->flag, 'invite');
    }

    public function deny(CoolQ $cq, string $reason){
        return $cq->setGroupAddRequest($this->flag, 'invite', false, $reason);
    }
}
