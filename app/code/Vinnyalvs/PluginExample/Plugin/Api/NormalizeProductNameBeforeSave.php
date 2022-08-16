<?php

namespace Vinnyalvs\PluginExample\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Vinnyalvs\Logger\Logger\Logger;

class NormalizeProductNameBeforeSave
{

    protected Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @param ProductRepositoryInterface $subject
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param bool $saveOptions
     * @return array
     */
    public function beforeSave(ProductRepositoryInterface $subject, ProductInterface $product, $saveOptions = false): array
    {

        $oldName = $product->getName();
        $case = mb_convert_case($oldName, MB_CASE_TITLE);
        $product->setName($case);
        $this->logger->info("Executing beforeSave: converting" . $oldName ." to " . $case);
        return [$product, $saveOptions];
    }

}


