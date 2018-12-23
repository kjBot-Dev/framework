<?php
namespace kjBot\Framework;

use kjBot\Framework\Event\MessageEvent;
use kjBot\SDK\CoolQ;

abstract class Module{
    public $needCQ = false;
    public abstract function process(array $args, MessageEvent $event, CoolQ $cq = NULL): Message;
}
