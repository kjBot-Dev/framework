<?php
namespace kjBot\Framework;

use kjBot\Framework\Event\MessageEvent;

abstract class Module{
    public abstract function process(array $args, MessageEvent $event): Message;
}
