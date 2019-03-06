<?php
namespace kjBot\Framework;

//方法的可能分支过多以至于懒得枚举
abstract class Plugin{
    public $handleDepth = 0; //该数值决定了要捕获事件的深度，可能的值为[0-3]
    //0: handle
	//1: {$event_type}
	//2: {$event_type}_{{$event_type}_type}
	//3: {$event_type}_{{$event_type}_type}_{$sub_type}
    public $handleQueue = false; //声明是否要捕获消息队列
    private function beforePostMessage(array &$messageQueue){}
}
