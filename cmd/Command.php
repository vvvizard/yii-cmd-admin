<?php
namespace app\cmd;

use app\cmd\CommandContext;
abstract class Command
{
 abstract public function execute(CommandContext $context):bool;
 
}
