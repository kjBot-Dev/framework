<?php
namespace kjBot\Framework\Event;

class MessageEvent extends BaseEvent{
    public $msgType;
    public $subType;
    public $font;
    public $msgId;
    protected $msg;
    protected $rMsg;
    protected $senderInfo;

    public function __construct($obj){
        if($obj->post_type!=='message')throw new Exception();
        parent::__construct($obj);
        $this->msgType = $obj->message_type;
        $this->subType = $obj->sub_type;
        $this->font = $obj->font;
        $this->msgId = $obj->message_id;
        $this->msg = $obj->message;
        $this->rMsg = $obj->raw_message;
        $this->senderInfo = new SenderInfo($obj->sender, ($this->msgType == 'group' && $this->subType == 'normal'));
    }

    public function __toString(){
        return $this->msg;
    }

    public function setMsg($msg){
        $this->msg = $msg;
        return $this;
    }

    public function getMsg(){
        return $this->msg;
    }

    public function getRawMsg(){
        return $this->rMsg;
    }

    public function getSenderInfo(){
        return $this->senderInfo;
    }

    public function fromGroup($id = NULL){
        if($id !== NULL){
            return $this->groupId == $id;
        }else return $this->msgType === 'group';
    }
}