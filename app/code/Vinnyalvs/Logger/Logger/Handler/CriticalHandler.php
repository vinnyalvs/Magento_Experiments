<?php
namespace Vinnyalvs\Logger\Logger\Handler;
use Monolog\Logger as MonologLogger;

class CriticalHandler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = MonologLogger::CRITICAL;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/custom-critical.log';
}
