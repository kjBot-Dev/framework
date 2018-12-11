<?php
namespace kjBot\Framework\Event;

class Sender{
    public $nickname;
    protected $age;
    protected $sex;
    private $userId;

    public $groupSender = false;

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

        if($isGroup){
            $this->card = $obj->card;
            $this->level = $obj->level;
            $this->role = $obj->role;
            $this->title = $obj->title;
            $this->area = $obj->area;
        }
    }

    public function getID(){
        return $userId;
    }

}