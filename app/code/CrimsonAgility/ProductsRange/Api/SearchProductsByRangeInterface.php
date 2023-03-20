<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Validation\ValidationException;

/**
 * Search Products Given a Low Price Limit and a Upper Price Limit
 */
interface SearchProductsByRangeInterface
{
    public const SEARCH_PAGE_SIZE = 10;
    /**
     * @param float $lowPrice
     * @param float $highPrice
     * @param string $sorting
     * @return array
     *  @throws ValidationException|NoSuchEntityException
     */
    public function execute(float $lowPrice, float $highPrice, string $sorting): array;
}
