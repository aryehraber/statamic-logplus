<?php

namespace Statamic\Addons\Logplus;

use Log;
use Monolog\Logger;

class Logplus
{
    public $levels;

    public function __construct()
    {
        $this->levels = $this->getLevels();
    }

    public function log($level, $message, array $context = [])
    {
        if (! in_array($level, $this->levels)) {
            $availableLevels = implode(', ', $this->levels);

            throw new \InvalidArgumentException("Level [{$level}] is not defined, use one of: {$availableLevels}");
        }

        Log::$level($message, $context);
    }

    protected function getLevels()
    {
        return array_map(function ($level) {
            return strtolower($level);
        }, array_keys(Logger::getLevels()));
    }
}
