<?php
namespace kjBot\Framework;

use kjBot\SDK\CoolQ;
use kjBot\Framework\Event\MessageEvent;

abstract class Module{
    const needCQ = false;
    public function process(array $args, MessageEvent $event){}
    public function processWithCQ(array $args, MessageEvent $event, CoolQ $cq = NULL){}
}
