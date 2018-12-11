<?php

if(function_exists('fastcgi_finish_request'))fastcgi_finish_request();
require_once('init.php');

$kjBot = new kjBot\Framework\KjBot($Config['self_id']);
$kjBot->bindCoolQ(new kjBot\SDK\CoolQ($Config['API'], $Config['token']));

$storage = new kjBot\Framework\Core\DataStorage('../');
$rawPostData = file_get_contents('php://input');
$postData = json_decode($rawPostData);
$event = kjBot\Framework\Event\EventFactory::createEventFrom($postData);
$pluginMethods = event2pluginMethods($event);

foreach($Plugins as $pluginName){
    $plugin = (new ReflectionClass($pluginName))->newInstance();
    if($plugin instanceof kjBot\Framework\Plugin){
        try{
            $method = new ReflectionMethod($plugin, $pluginMethods[$plugin->handleDepth]);
        }catch(ReflectionException $e){
            _log('NOTICE', "{$pluginName} not implements {$pluginMethods[$plugin->handleDepth]}");
        }finally{
            try{
                if($method !== NULL)
                $kjBot->addMessage($method->invoke($plugin, $event));
            }catch(ReflectionException $e){
                throw $e;
            }
        }
    }else{
        _log('WARNING', "{$pluginName} is not a kjBot plugin.");
    }
}

if($event instanceof kjBot\Framework\Event\MessageEvent){
    $event->setMsg(kjBot\SDK\CQCode::DecodeCQCode($event->getMsg()));
    $matches = preg_split('/\s+/', $event->__toString());
    $command = rtrim($matches[0]);
    if($matches==NULL){
        $command = $event->getMsg();
        $matches = [$command];
    }
    if(isset($Modules[$command])){
        $module = (new ReflectionClass($Modules[$command]))->newInstance();
        if($module instanceof kjBot\Framework\Module){
            d("{$Modules[$command]} handled command: {$command}");
            $kjBot->addMessage($module->process($matches, $event));
        }
    }
}

foreach($Plugins as $pluginName){
    $plugin = (new ReflectionClass($pluginName))->newInstance();
    if($plugin instanceof kjBot\Framework\Plugin){
        $plugin->beforePostMessage($kjBot->getMessageQueue());
    }else{
        _log('WARNING', "{$pluginName} is not a kjBot plugin.");
    }
}

$kjBot->postMessage();
