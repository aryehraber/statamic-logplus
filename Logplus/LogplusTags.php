<?php

namespace Statamic\Addons\Logplus;

use Statamic\API\Str;
use Statamic\Extend\Tags;

class LogplusTags extends Tags
{
    protected $logplus;

    public function __construct(Logplus $logplus)
    {
        $this->logplus = $logplus;
    }

    public function __call($method, $args)
    {
        return $this->index($method);
    }

    public function index($level = null)
    {
        $level = $level ?: $this->get('level', 'debug');

        $this->logplus->log($level, $this->get('message'), $this->getContext());
    }

    protected function getContext()
    {
        $rawContext = $this->get('context', '');
        $context = collect(explode('|', $rawContext));

        if (Str::contains($rawContext, ':')) {
            $context = $context->map(function ($item) {
                $value = explode(':', $item);
                $key = array_shift($value);

                if (count($value) === 1) {
                    $value = $value[0];
                }

                return [$key => $value];
            })->collapse();
        }

        return $context->filter()->toArray();
    }
}
