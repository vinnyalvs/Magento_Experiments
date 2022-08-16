<?php
namespace Vinnyalvs\Logger\Logger\Handler;
use Monolog\Logger as MonologLogger;

class InfoHandler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     *
     * @var int
     */
    protected $loggerType = MonologLogger::INFO;

    /**
     * File name
     *
     * @var string
     */
    protected $fileName = '/var/log/custom-info.log';
}
