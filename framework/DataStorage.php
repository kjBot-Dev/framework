<?php
namespace kjBot\Framework;

class DataStorage{
    public static $storagePath;

    public function __construct(string $dir){
        static::$storagePath = realpath(dirname($dir).'/storage').'/';
    }

    public static function GetSQLiteFilepath(string $name){
        return static::$storagePath.$name.'.db';
    }

    public static function SetData(string $filePath, $data, bool $pending = false){
        if(!file_exists(dirname(static::$storagePath.'data/'.$filePath))){
            if(!mkdir(dirname(static::$storagePath.'data/'.$filePath), 0777, true))
            throw new \Exception('Failed to create data dir');
        }
        return @file_put_contents(static::$storagePath.'data/'.$filePath, $data, $pending?(FILE_APPEND | LOCK_EX):LOCK_EX);
    }

    public static function GetData(string $filePath){
        return @file_get_contents(static::$storagePath.'data/'.$filePath);
    }

    public static function DelData(string $filePath){
        return @\unlink(static::$storagePath.'data/'.$filePath);
    }
}