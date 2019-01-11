<?php
namespace kjBot\Framework\Event;

class SenderInfo{
    public $nickname;
    protected $age;
    protected $sex;
    protected $userId;

    public $isGroupSender;

    public $card;
    public $level;
    public $role;
    public $title;
    protected $area;

    public function __construct($obj, bool $isGroup = false){
        $this->nickname = $obj->nickname;
        $this->age = $obj->age;
        $this->sex = $obj->sex;
        $this->userId = $obj->user_id;

        $this->isGroupSender = $isGroup;

        if($isGroup){
            $this->card = $obj->card;
            $this->level = $obj->level;
            $this->role = $obj->role;
            $this->title = $obj->title;
            $this->area = $obj->area;
        }
    }

    public function getAge(){
        return $this->age;
    }

    public function getArea(){
        return $this->area;
    }

    public function getID(){
        return $this->userId;
    }

    public function getSex(){
        return $this->sex;
    }

    
}