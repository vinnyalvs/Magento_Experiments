<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Test\Unit\Model;

use CrimsonAgility\ProductsRange\Api\SearchProductsByRangeInterface;
use CrimsonAgility\ProductsRange\Model\ValidatorChain;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Model\Stock\StockItemRepository;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\Validation\ValidationException;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManager;
use PHPUnit\Framework\TestCase;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Validation\ValidationResult;


use CrimsonAgility\ProductsRange\Model\SearchProductsByRange;


class SearchProductsByRangeTest extends TestCase
{
    /**
     * @var StockItemRepository
     */
    private StockItemRepository $stockItemRepositoryMock;

    /**
     * @var StoreManager
     */
    private StoreManager $storeManagerMock;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactoryMock;

    /**
     * @var Collection
     */
    private Collection $collectionMock;
    /**
     * @var ValidatorChain $validatorChain;
     */
    private ValidatorChain $validatorChainMock;

    /**
     * @var ProductInterface $productMock;
     */
    private ProductInterface $productMock;

    /**
     * @var ValidationResult $validationResulMock;
     */
    private ValidationResult $validationResulMock;

    /**
     * @var SearchProductsByRange $instance;
     */
    private SearchProductsByRange $instance;

    /**
     * Test setup
     */
    protected function setUp(): void
    {
        $this->setMocks();
        $this->setInstance();
    }

    /**
     * @return void
     */
    private function setMocks(): void
    {
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->collectionMock = $this->createMock(Collection::class);
        $this->storeManagerMock = $this->createMock(StoreManager::class);
        $this->storeMock = $this->createMock(Store::class);
        $this->stockItemRepositoryMock = $this->createMock(StockItemRepository::class);
        $this->validatorChainMock = $this->createMock(ValidatorChain::class);
        $this->validationResulMock = $this->createMock(ValidationResult::class);
        $this->productMock = $this->getMockBuilder(ProductInterface::class)
            ->disableOriginalConstructor()
            ->addMethods([
                'getProductUrl'
            ])
            ->getMockForAbstractClass();
        $this->stockItemMock = $this->createMock(StockItemInterface::class);
        $this->stockItemRepositoryMock = $this->createMock(StockItemRepository::class);
    }

    /**
     * Set Instance attribute
     */
    private function setInstance(): void
    {
        $this->instance = new SearchProductsByRange(
            $this->validatorChainMock,
            $this->collectionFactoryMock,
            $this->storeManagerMock,
            $this->stockItemRepositoryMock
        );
    }

    /**
     * @dataProvider executeDataProvider
     */
    public function testExecute(float $highPrice, float $lowPrice, string $sorting, bool $valid)
    {
        $params['high_price'] = $highPrice;
        $params['low_price'] = $lowPrice;
        $params['sorting'] = $sorting;

        $expectedResult = [
            [
                'thumbnail' => 'www.baseurl.com/media/catalog/product',
                'sku' => 'SKU-TEST',
                'name' => 'Swimsuit',
                'qty' => 100,
                'price' => 25.0,
                'url' => 'www.baseurl.com/product'
            ]
        ];

        $this->validatorChainMock
            ->expects($this->once())
            ->method('validate')
            ->with($params)
            ->willReturn($this->validationResulMock);

        $this->validationResulMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn($valid);

        if($valid){
            $this->prepareMockforExecute($highPrice,  $lowPrice,  $sorting,  $valid);
        } else {
            $this->expectException(ValidationException::class);
        }

        $result = $this->instance->execute($lowPrice, $highPrice, $sorting);

        $this->assertEquals($expectedResult, $result);

    }

    private function prepareMockforExecute(float $highPrice, float $lowPrice, string $sorting, bool $valid):void
    {
        $iterator = new \ArrayIterator([$this->productMock]);

        $this->collectionFactoryMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('setPageSize')
            ->with(SearchProductsByRangeInterface::SEARCH_PAGE_SIZE)
            ->willReturn($this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('addAttributeToFilter')
            ->with('price', ['from' => $lowPrice, 'to' => $highPrice])
            ->willReturn($this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('setOrder')
            ->with('price', 'ASC')
            ->willReturn($this->collectionMock);

        $this->collectionMock
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($iterator);

        $this->storeManagerMock
            ->expects($this->once())
            ->method('getStore')
            ->willReturn($this->storeMock);

        $this->productMock
            ->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $this->storeMock
            ->expects($this->once())
            ->method('getBaseUrl')
            ->willReturn('www.baseurl.com/');

        $this->stockItemRepositoryMock
            ->expects($this->once())
            ->method('get')
            ->with(1)
            ->willReturn($this->stockItemMock);

        $this->stockItemMock
            ->expects($this->once())
            ->method('getQty')
            ->willReturn(100);

        $this->productMock
            ->expects($this->once())
            ->method('getSku')
            ->willReturn('SKU-TEST');

        $this->productMock
            ->expects($this->once())
            ->method('getName')
            ->willReturn('Swimsuit');

        $this->productMock
            ->expects($this->once())
            ->method('getPrice')
            ->willReturn(25.0);

        $this->productMock
            ->expects($this->once())
            ->method('getProductUrl')
            ->willReturn('www.baseurl.com/product');
    }

    private function executeDataProvider(): array
    {
        $highPrice = 100.50;
        $lowPrice = 50;
        $sorting = "ascending";

        return [
            'Normal Execute Flow when params are valid' =>[$highPrice, $lowPrice, $sorting, true],
            'Fall into invalid scenario where low range is bigger than high' => [$lowPrice, $highPrice, $sorting, false],
        ];
    }
}
