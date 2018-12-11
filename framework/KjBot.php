<?php
namespace kjBot\Framework;

use kjBot\SDK\CoolQ;

class KjBot{

    private $cq;
    protected $selfId;
    protected $messageQueue;

    public function __construct($self_id){
        $this->selfId = $self_id;
    }

    public function bindCoolQ(CoolQ $coolQ){
        $this->cq = $coolQ;
    }

    public function addMessage(?Message $msg){
        $this->messageQueue[]= $msg;
    }

    public function postMessage(){
        foreach($this->messageQueue as $message){
            if($message instanceof Message){
                $message->send($this->cq);
            }
        }
    }

    public function &getMessageQueue(){
        return $this->messageQueue;
    }
}
