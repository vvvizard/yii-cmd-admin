<?php

namespace app\cmd;

class CommandFactory {
    private static $dir = 'Commands';

    public static function getCommand( string $action = 'Default'): Command     {
       self::validate($action);
       $class = self::getClass($action);
       return new $class();

    }

    protected static function validate(string $action) {
        if ( preg_match('/\W/', $action) ) {
            throw new CommandNotFoundException("Invalid characters in command");
        }
    }

    protected static function getClass(string $action){
        $class = __NAMESPACE__ . "\\" . self::$dir. ucfirst(strtolower($action)) . "Command";
        if(! class_exists($class)){
            throw new CommandNotFoundException(" Class not " . $class ." found");
        }
        return $class;
    }
}