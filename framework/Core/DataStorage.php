<?php
namespace kjBot\Framework\Core;

class DataStorage{
    private static $storagePath;

    public function __construct(string $dir){
        $this->storagePath = dirname($dir).'/storage/';
    }

    public static function getSQLiteFilepath(string $name){
        return self::storagePath.$name.'.db';
    }

    public static function setData(string $filePath, $data, bool $pending = false){
        if(!file_exists(dirname(self::storagePath.'data/'.$filePath))){
            if(!mkdir(dirname(self::storagePath.'data/'.$filePath), 0777, true))
            throw new \Exception('Failed to create data dir');
        }
        return file_put_contents(self::storagePath.'data/'.$filePath, $data, $pending?(FILE_APPEND | LOCK_EX):LOCK_EX);
    }

    public static function getData(string $filePath){
        return file_get_contents(self::storagePath.'data/'.$filePath);
    }
}