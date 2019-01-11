<?php
namespace kjBot\Framework\Event;

class MetaHeartbeatEvent extends MetaEvent{
    public $status;
    public function __construct($obj){
        parent::__construct($obj);
        $this->status = $obj->status;
    }
}
