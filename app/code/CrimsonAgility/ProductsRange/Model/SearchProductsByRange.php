<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Model;

use CrimsonAgility\ProductsRange\Api\SearchProductsByRangeInterface;
use CrimsonAgility\ProductsRange\Api\ValidatorInterface;

class SearchProductsByRange implements SearchProductsByRangeInterface
{

    public function __construct()
    {

    }
    /**
     * @inheritDoc
     */
    public function execute(float $lowPrice, float $highPrice, string $sorting): array
    {
        // TODO: Implement execute() method.
    }
}
