<?php


namespace Vinnyalvs\Logger\Logger\Handler;

use Monolog\Logger as MonologLogger;

class DebugHandler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = MonologLogger::DEBUG;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/custom-critical.log';
}
