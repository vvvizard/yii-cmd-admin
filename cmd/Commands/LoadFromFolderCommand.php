<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext, QueryParser};
use app\cmd\Commands\Category\CategoryCreateCommand;
use app\cmd\CommandFactory;
use app\models\Category;
use Yii;

class LoadFromFolderCommand extends Command
{

    private $title = 'LoadFromFolder';

    public $requiredParams = ['folder'];

    // public const STORAGE = Yii::$app->params['rootDir'] . DIRECTORY_SEPARATOR . 'storage';
    public const CONFIG_FILE = 'config.txt';
    public const TYPE_PATTERN = '/type:/';

    public function execute(CommandContext $context): bool
    {
        $dir = __DIR__;
        $folder = $context->get('folder');
        $storagePath = Yii::$app->params['rootDir'] . DIRECTORY_SEPARATOR . 'storage';
        $file = $storagePath . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . 'config.txt';

        if (!is_file($file)) {

            throw new \Exception(self::CONFIG_FILE . " NOT FOUND");
        }

        $config = $this->parseConfig($file);
        $query = $this->makeQuery($config);
        $query = new QueryParser($query);
        $context = new CommandContext($query);
        $command = CommandFactory::getCommand($query->getCommandTitle());
        $command->execute($context);
        //$command = (new CommandFactory())->getFromConfig($config);

        return true;
    }

    protected function parseConfig($file)
    {
        $content = file_get_contents($file);

        if (empty($content)) {
            throw new \Exception("Config file is empty: " . $file);
        }

        $pattern = '/(\w+):("(?:[^"\\\\]|\\\\.)*"|[^\s;]+);?/';

        preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            throw new \Exception("No parameters found in config file");
        }

        $result = [];
        foreach ($matches as $match) {
            $key = $match[1];
            $value = $match[2];

            if (preg_match('/^"(.*)"$/s', $value, $quotedValue)) {
                $value = $quotedValue[1];
            }

            $result[$key] = trim($value);
        }

        if (!isset($result['type'])) {
        //    throw new \Exception("Required param 'type' not found in config");
        }

        return $result;

    }

    protected function makeQuery(array $config)
    {
        return $config['type']
            . ' --create --title='
            . $config['title']
            . ' --description='
            . $config['description'];
    }

}