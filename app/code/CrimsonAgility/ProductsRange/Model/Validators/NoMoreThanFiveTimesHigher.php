<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Model\Validators;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use CrimsonAgility\ProductsRange\Api\ValidatorInterface;

/**
 * @inheritDoc
 */
class NoMoreThanFiveTimesHigher implements ValidatorInterface
{

    /**
     * @param ValidationResultFactory $validationResultFactory
     */
    public function __construct(
        private readonly ValidationResultFactory $validationResultFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(array $params): ValidationResult
    {
        $highPrice = $params['high_price'] ?? 0.0;
        $lowPrice = $params['low_price'] ?? 0.0;
        $errors = [];

        if ($highPrice !== null || $lowPrice !== null) {
            if($highPrice >= 5* $lowPrice){
                $errors[] = __(
                    'High Price can no more than 5x higher than the entered "Low Price.'
                );
            }
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
