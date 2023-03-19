<?php

declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Directory\Model\CurrencyFactory;

/**
 * Block to show Advanced Search to customer
 */
class ProductsRange extends Template
{
    public function __construct(
        private readonly Context $context,
        private readonly StoreManagerInterface $storeManager,
        private readonly CurrencyFactory $currencyFactory,
        private readonly array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getText(): string
    {
        return "Alo Mundo";
    }

    public function getFormActionUrl(): string
    {
        return "rest/V1/products/search";
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getStoreCurrency():string
    {
        return $this->storeManager->getStore()->getCurrentCurrencyCode();
    }
}
