<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use app\cmd\Commands\Category\CategoryCreateCommand;
use app\cmd\CommandFactory;
use app\models\Category;
use Yii;

class LoadFromFolderCommand extends Command
{

    private $title = 'LoadFromFolder';

    public $requiredParams = ['folder'];

    public const CONFIG_FILE = 'config.txt';
    public const TYPE_PATTERN = '/type:/';

    public function execute(CommandContext $context): bool
    {

        $folder = $context->get('folder');
        $file = $folder . DIRECTORY_SEPARATOR . self::CONFIG_FILE;

        if (!is_file($file)) {

            throw new \Exception(self::CONFIG_FILE . " NOT FOUND");
        }

        $config = $this->parseConfig($file);
        $command = (new CommandFactory())->getFromConfig($config);

        return true;
    }

    protected function parseConfig($file)
    {
        $config = file($file);
        $type = preg_grep(self::TYPE_PATTERN, $config);

        if (empty($type)) {

            throw new \Exception("Required param /type/ not found ");
        }

        $result = array_reduce($config, function ($r, $i) {
            return array_merge($r, [explode(':', $i)[0] => explode(':', $i)[1]]);
        }, []);

        return $result;
    }

}