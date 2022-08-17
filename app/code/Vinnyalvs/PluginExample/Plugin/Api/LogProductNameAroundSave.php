<?php

namespace Vinnyalvs\PluginExample\Plugin\Api;;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Vinnyalvs\Logger\Logger\Logger;

class LogProductNameAroundSave
{
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param callable $proceed
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param bool $saveOptions
     * @return ProductInterface
     */
    public function aroundSave(ProductRepositoryInterface $subject, callable $proceed, ProductInterface $product, $saveOptions = false): ProductInterface
    {
        $this->logger->info("Executing aroundSave 1° .. "  );
        $call = $proceed($product, $saveOptions);
        $this->logger->info("Executing aroundSave 2° .. "  );
        return $call;
    }
}
