<?php

if(function_exists('fastcgi_finish_request'))fastcgi_finish_request();
require_once('init.php');

$kjBot = new kjBot\Framework\KjBot(new kjBot\SDK\CoolQ($Config['API'], $Config['token']), $Config['self_id']);

$storage = new kjBot\Framework\Core\DataStorage(__DIR__.'/../../');
$rawPostData = file_get_contents('php://input');
$postData = json_decode($rawPostData);
if(isset($postData->message))$postData->message = kjBot\SDK\CQCode::DecodeCQCode($postData->message);
$event = kjBot\Framework\Event\EventFactory::createEventFrom($postData);
$pluginMethods = event2pluginMethods($event);

try{

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
            }catch(kjBot\Framework\QuitException $e){
                $kjBot->addMessage($event->sendBack($e->getMessage()));
            }catch(\TypeError $e){
                d($e->getMessage());
            }catch(\Exception $e){
                _log('ERROR', "{$pluginName}: {$e->getMessage()}");
            }
        }
    }else{
        _log('WARNING', "{$pluginName} is not a kjBot plugin.");
    }
}

if($event instanceof kjBot\Framework\Event\MessageEvent){
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
            try{
                if($module->needCQ){
                    _log('NOTICE', "{$module} request CoolQ instance.");
                    $kjBot->addMessage($module->processWithCQ($matches, $event, $kjBot->getCoolQ()));
                }else{
                    $kjBot->addMessage($module->process($matches, $event));
                }
            }catch(kjBot\Framework\QuitException $e){
                $kjBot->addMessage($event->sendBack($e->getMessage()));
            }catch(\TypeError $e){
                preg_match('/Argument \d+ passed to \S+ must be of the type (\S+), (\S+) given/', $e->getMessage(), $match);
                d($e->getMessage());
                $kjBot->addMessage($event->sendBack("[ERROR]: 一个需要 {$match[1]} 的参数位置收到了一个 {$match[2]}"));
            }
        }
    }
}

}catch(kjBot\Framework\PanicException $e){
    $kjBot->addMessage(notifyMaster(($e->getMessage())));
}

foreach($Plugins as $pluginName){
    $plugin = (new ReflectionClass($pluginName))->newInstance();
    if($plugin instanceof kjBot\Framework\Plugin){
        if((new ReflectionClass($pluginName))->hasMethod('beforePostMessage')){
            _log('NOTICE', "{$pluginName} handlded MessageQueue.");
            try{
                $plugin->beforePostMessage($kjBot->getMessageQueue());
            }catch(Exception $e){
                _log('ERROR', "{$pluginName}: {$e->getMessage()}");
            } 
        }
    }else{
        _log('WARNING', "{$pluginName} is not a kjBot plugin.");
    }
}

$kjBot->postMessage();
