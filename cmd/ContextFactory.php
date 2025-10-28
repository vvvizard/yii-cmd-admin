<?php

namespace app\cmd;

class ContextFactory extends Factory
{
    protected static $type = 'Context';
    protected static $dir = 'Context';

    public static function getContext(string $action = 'Default'): Command
    {
        self::validate($action);
        $class = self::getClass($action);
        return new $class();

    }
       
}