<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Model;

use CrimsonAgility\ProductsRange\Api\SearchProductsByRangeInterface;
use Magento\Catalog\Api\Data\ProductAttributeMediaGalleryEntryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\ProductRepositoryInterfaceFactory;

/**
 * @inheritdoc
 */
class SearchProductsByRange implements SearchProductsByRangeInterface
{
    /**
     * @param ValidatorChain $validatorChain
     * @param CollectionFactory $productCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param StockItemRepository $stockItemRepository
     */
    public function __construct(
        private readonly ValidatorChain $validatorChain,
        private readonly CollectionFactory $productCollectionFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly StockItemRepository $stockItemRepository,
    ){}

    /**
     * @inheritDoc
     */
    public function execute(float $lowPrice, float $highPrice, string $sorting): array
    {
        $params['high_price'] = $highPrice;
        $params['low_price'] = $lowPrice;
        $params['sorting'] = $sorting;

        $validationResult = $this->validatorChain->validate($params);

        if (!$validationResult->isValid()) {
            throw new ValidationException(__('Parameter Validation Failed'), null, 0, $validationResult);
        }

        $products = $this->productCollectionFactory->create()
            ->setPageSize(self::SEARCH_PAGE_SIZE);
        $products = $products->addAttributeToFilter(
            'price',
            ['from' => $lowPrice, 'to' => $highPrice]
        )->setOrder('price',$this->getSortOrder($sorting));

        $productsResult = [];

        /** @var ProductInterface $product */
        foreach ($products->getItems() as $product) {
            $productsResult[] = $this->formatResultData($product);
        }

        return $productsResult;
    }

    /**
     * @param string $sorting
     * @return string
     */
    private function getSortOrder(string $sorting): string
    {
           $sorting = strtolower($sorting);
           return match($sorting) {
               'ascending' => 'ASC',
               'descending' => 'DESC',
                default => 'ASC'
           };
    }

    /**
     * @param ProductInterface $product
     * @return array
     * @throws NoSuchEntityException
     */
    private function formatResultData(ProductInterface $product): array
    {
        /** @var ProductAttributeMediaGalleryEntryInterface[] $images */
        $images = $product->getMediaGalleryEntries();
        $path = '';
        if(isset($images[0])){
            $path = $images[0]->getFile();
        }

        return [
            'thumbnail' => $this->storeManager->getStore()->getBaseUrl()
                . 'media/catalog/product' .  $path,
            'sku' => $product->getSku(),
            'name' => $product->getName(),
            'qty' => $this->stockItemRepository->get($product->getId())->getQty(),
            'price' => $product->getPrice(),
            'url' => $product->getProductUrl(),
        ];
    }
}

