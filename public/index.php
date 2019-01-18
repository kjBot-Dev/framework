<?php

if(function_exists('fastcgi_finish_request'))fastcgi_finish_request();
require_once('init.php');

$kjBot = new kjBot\Framework\KjBot(new kjBot\SDK\CoolQ($Config['API'], $Config['token']), $Config['self_id']);

$storage = new kjBot\Framework\DataStorage(__DIR__.'/../../');
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
            $methodNeedCQ = (new ReflectionClass($pluginName))->getConstant('cq_'.$pluginMethods[$plugin->handleDepth]);
            $methodName = ($methodNeedCQ?'coolq_':'').$pluginMethods[$plugin->handleDepth];
            $method = new ReflectionMethod($plugin, $methodName);
            try{
                if($methodNeedCQ){
                    _log('NOTICE', "{$pluginName} handle {$pluginMethods[$plugin->handleDepth]} request CoolQ instance.");
                    $kjBot->addMessage(@$method->invoke($plugin, $event, $kjBot->getCoolQ()));
                }else{
                    $kjBot->addMessage(@$method->invoke($plugin, $event));
                }
            }catch(kjBot\Framework\QuitException $e){
                $kjBot->addMessage($event->sendBack($e->getMessage()));
            }catch(\TypeError $e){
                d($e->getMessage());
            }
        }catch(ReflectionException $e){
            //silence catch
        }catch(\Exception $e){
            _log('ERROR', "{$pluginName}: {$e->getMessage()}");
        }
    }else{
        _log('WARNING', "{$pluginName} is not a kjBot plugin.");
    }
}

if(kjBot\Framework\SilenceModule::$silence){}
else{
if($event instanceof kjBot\Framework\Event\MessageEvent){
    $matches = parseCommand($event->__toString());
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
                    d("{$Modules[$command]} request CoolQ instance.");
                    $kjBot->addMessage($module->processWithCQ($matches, $event, $kjBot->getCoolQ()));
                }else{
                    $kjBot->addMessage($module->process($matches, $event));
                }
            }catch(kjBot\Framework\QuitException $e){
                $kjBot->addMessage($event->sendBack($e->getMessage()));
            }catch(\TypeError $e){
                _log('ERROR', $e->getMessage());
            }
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
        if($plugin->handleQueue){
            d("{$pluginName} handled MessageQueue.");
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
