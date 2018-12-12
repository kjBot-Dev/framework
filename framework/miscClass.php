<?php
namespace kjBot\Framework;

class TargetType{
    const Group = 0;
    const Private = 1;
}

class KjBotException extends \Exception{
    public $prompt;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = NULL){
        $this->message = "[{$this->prompt}]: {$message}";
        $this->code = $code;
        $this->previous = $previous;
    }
}

class QuitException extends KjBotException{var $prompt = 'ERROR';}

class PanicException extends KjBotException{var $prompt = 'PANIC';}
