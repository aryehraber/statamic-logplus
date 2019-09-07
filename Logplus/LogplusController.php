<?php

namespace Statamic\Addons\Logplus;

use Statamic\Extend\Controller;

class LogplusController extends Controller
{
    protected $logplus;

    public function __construct(Logplus $logplus)
    {
        $this->logplus = $logplus;
    }

    public function postLog()
    {
        $level = request('level', 'debug');
        $message = request('message');
        $context = request('context', []);

        try {
            $this->logplus->log($level, $message, $context);
        } catch (\InvalidArgumentException $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        return response(['success' => true], 200);
    }
}
