<?php

namespace app\cmd;

class Factory
{
    protected static $type;
    protected static $dir = 'default';
    protected static function validate(string $action)
    {
        if (preg_match('/\W/', $action)) {
            throw new CommandNotFoundException("Invalid characters in command");
        }
    }

    protected static function getClass(string $action)
    {
        $class = __NAMESPACE__ . "\\" . static::$dir . "\\" . ucfirst(strtolower($action)) . static::$type;
        if (!class_exists($class)) {
            throw new CommandNotFoundException("command not exist");
        }
        return $class;
    }
}