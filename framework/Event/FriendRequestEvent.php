<?php
namespace kjBot\Framework\Event;

use kjBot\SDK\CoolQ;

class FriendRequestEvent extends RequestEvent{
    use RequestCommon;

    public function __construct($obj){
        parent::__construct($obj);
        $this->comment = $obj->comment;
        $this->flag = $obj->flag;
    }

    public function accept(CoolQ $cq, string $remark = ''){
        return $cq->setFriendAddRequest($this->flag, true, $remark);
    }

    public function deny(CoolQ $cq){
        return $cq->setFriendAddRequest($this->flag, false);
    }
}
