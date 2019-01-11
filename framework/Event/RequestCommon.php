<?php
namespace kjBot\Framework\Event;

trait RequestCommon{
    public $comment;
    protected $flag;

    public function getFlag(){
        return $this->flag;
    }
}
