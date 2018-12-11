<?php
namespace kjBot\Framework;

class Message{
    protected $type = TargetType::Group;
    protected $id;
    protected $msg;
    protected $escape = false;
    protected $async = false;

    public function __construct(string $message, $target_id, $target_type = TargetType::Group, bool $auto_escape = false, bool $async = false){
        $this->msg = $message;
        $this->id = $target_id;
        $this->type = $target_type;
        $this->escape = $auto_escape;
        $this->async = $async;
    }

    public function __toString(){
        return "[To:{$this->id}".($this->type?'*':'')."] {$this->msg}"; //*为私聊
    }

    function send($cq){
        if($this->type === TargetType::Group){
            if($this->async){
                $cq->sendGroupMsgAsync($this->id, $this->msg, $this->escape);
            }else{
                $cq->sendGroupMsg($this->id, $this->msg, $this->escape);
            }
        }else if($this->type === TargetType::Private){
            if($this->async){
                $cq->sendPrivateMsgAsync($this->id, $this->msg, $this->escape);
            }else{
                $cq->sendPrivateMsg($this->id, $this->msg, $this->escape);
            }
        }
    }
}
