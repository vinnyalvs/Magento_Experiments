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
    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param CurrencyFactory $currencyFactory
     * @param array $data
     */
    public function __construct(
        private readonly Context $context,
        private readonly StoreManagerInterface $storeManager,
        private readonly CurrencyFactory $currencyFactory,
        private readonly array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
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
