<?php
namespace kjBot\Framework\Event;

class GroupFileUploadEvent extends BaseEvent{
    use GroupEvent;
    public $file;
    public function __construct($obj){
        parent::__construct($obj);
        $this->groupId = $obj->group_id;
        $this->file = $obj->file;
    }
}