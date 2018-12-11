<?php
namespace kjBot\Framework\Core;

class DataStorage{
    private $storagePath;

    public function __construct(){
        $this->storagePath = dirname('../storage');
    }

    public function getSQLiteFilepath(string $name){
        return $this->storagePath.'/'.$name.'.db';
    }
}