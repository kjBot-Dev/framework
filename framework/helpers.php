<?php

use kjBot\Framework\Event\BaseEvent;

require_once('miscClass.php');

function str_replace_once(string $needle, string $replace, string $haystack): string{
    $pos = strpos($haystack, $needle);
    if($pos === false){
        return $haystack;
    }
    return substr_replace($haystack, $replace, $pos, strlen($needle));
}

function export($x){
    return var_export($x, false);
}

function q($str, int $code = 0, Throwable $prievous = NULL){
    _log('PURPOSE', $str);
    throw new \Exception($str."\n", $code, $prievous);
}

function event2pluginMethods(kjBot\Framework\Event\BaseEvent $event): array{
    $methods[0] = 'handle';
    $methods[1] = $event->postType;
    $methods[2] = $methods[1];
    $methods[2].= isset($event->msgType)?'_'.$event->msgType:'';
    $methods[2].= isset($event->noticeType)?'_'.$event->noticeType:'';
    $methods[2].= isset($event->requestType)?'_'.$event->requestType:'';
    $methods[3] = $methods[2];
    $methods[3].= isset($event->subType)?'_'.$event->subType:'';
    return $methods;
}

function _log(string $type, string $msg){
    global $Config;
    $log = '<'.date('Y-m-d H:i:s').'>['.$type.'] '.$msg."\n";
    if($Config['log_file'] !== NULL || $Config['log_file']!=='')file_put_contents($Config['log_file'], $log, FILE_APPEND);
}

function d(string $msg){
    global $Config;
    if($Config['DEBUG'])_log('DEBUG', $msg);
}

function notifyMaster(string $msg): kjBot\Framework\Message{
    global $Config;
    return new kjBot\Framework\Message($msg, $Config['master'], kjBot\Framework\TargetType::Private);
}

function sendPrivate(string $msg, BaseEvent $event): kjBot\Framework\Message{
    return new kjBot\Framework\Message($msg, $event->getId(), kjBot\Framework\TargetType::Private);
}

function sendBack(string $msg, BaseEvent $event): kjBot\Framework\Message{
    if($event->getGroupId()!==NULL)
    return new kjBot\Framework\Message($msg, $event->getGroupId(), kjBot\Framework\TargetType::Group);
    else return new kjBot\Framework\Message($msg, $event->getId(), kjBot\Framework\TargetType::Private);
}