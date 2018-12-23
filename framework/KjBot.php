<?php
namespace kjBot\Framework;

use kjBot\SDK\CoolQ;

class KjBot{

    private $cq;
    protected $selfId;
    protected $messageQueue = [];

    public function __construct(CoolQ $coolQ, $id = NULL){
        $this->cq = $coolQ;
        $this->selfId = $id;
    }

    public function getCoolQ(){
        return $this->cq;
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
