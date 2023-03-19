<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Api;

/**
 * TODO
 */
interface SearchProductsByRangeInterface
{
    /**
     * @param float $lowPrice
     * @param float $highPrice
     * @param string $sorting
     * @return array
     */
    public function execute(float $lowPrice, float $highPrice, string $sorting): array;
}
