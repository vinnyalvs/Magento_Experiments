<?php

namespace Vinnyalvs\PluginExample\Plugin\Api;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Vinnyalvs\Logger\Logger\Logger as Logger;

class LogProductNameAfterSave
{
    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductInterface $result
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param bool $saveOptions
     * @return ProductInterface
     */
    public function afterSave(ProductRepositoryInterface $subject, ProductInterface $result, ProductInterface $product, $saveOptions = false): ProductInterface
    {
        $this->logger->info("AAAAAAAAAAAAAAAAA Executing afterSave .. "  );
        return $result;
    }
}


