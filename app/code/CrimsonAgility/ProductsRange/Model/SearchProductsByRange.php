<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Model;

use CrimsonAgility\ProductsRange\Api\SearchProductsByRangeInterface;
use CrimsonAgility\ProductsRange\Api\ValidatorInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Validation\ValidationException;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\InventoryApi\Api\Data\StockInterface;

class SearchProductsByRange implements SearchProductsByRangeInterface
{

    public function __construct(
        private readonly ValidatorChain $validatorChain,
        private readonly CollectionFactory $productCollectionFactory,
        private readonly StockRegistryInterface $stockRegistry
    )
    {

    }

    /**
     * @inheritDoc
     * @throws ValidationException
     */
    public function execute(float $lowPrice, float $highPrice, string $sorting): array
    {
        $params['high_price'] = $lowPrice;
        $params['low_price'] = $highPrice;
        $params['sorting'] = $sorting;

        $validationResult = $this->validatorChain->validate($params);

        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Validation Failed'), null, 0, $validationResult);
        }

        $products = $this->productCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter(
                'price',
                ['from' => $lowPrice, 'to' => $highPrice]
            )
            ->setOrder('price', $sorting)
            ->setPageSize(10);

        $productsResult = [];
        /** @var ProductInterface $product */
        foreach ($products->getItems() as $product) {
            $productsResult[] = [
                'thumbnail' => $this->storeManager->getStore()->getBaseUrl()
                    . 'media/catalog/product' .
                    $product->getThumbnail(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'qty' => $product->getExtensionAttributes()->getStockItem()->getQty(),
                'price' => $product->getPrice(),
                'url' => $product->getProductUrl(),
            ];
        }
        return $productsResult;
    }
}
