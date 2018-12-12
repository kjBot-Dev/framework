<?php
namespace kjBot\Framework\Event;

class MessageEvent extends BaseEvent{
    public $msgType;
    public $sType;
    public $font;
    public $msgId;
    protected $msg;
    protected $rMsg;
    private $sender;

    public function __construct($obj){
        if($obj->post_type!=='message')throw new Exception();
        parent::__construct($obj);
        $this->msgType = $obj->message_type;
        $this->sType = $obj->sub_type;
        $this->font = $obj->font;
        $this->msgId = $obj->message_id;
        $this->msg = $obj->message;
        $this->rMsg = $obj->raw_message;
        $this->sender = new Sender($obj->sender, ($this->msgType == 'group' && $this->sType == 'normal'));
    }

    public function __toString(){
        return $this->msg;
    }

    public function setMsg($msg){
        $this->msg = $msg;
    }

    public function getMsg(){
        return $this->msg;
    }

    public function getRawMsg(){
        return $this->rMsg;
    }

    public function getSender(){
        return $this->sender;
    }
}