<?php

namespace app\cmd;

class CommandFactory extends Factory
{
    protected static $type = 'Command';
    protected static $dir = 'Commands';

    public static function getCommand(string $action = 'Default'): Command
    {
        self::validate($action);
        $class = self::getClass($action);
        return new $class();

    }

    public function getFromConfig(array $config){
 
        return [];
    }

}