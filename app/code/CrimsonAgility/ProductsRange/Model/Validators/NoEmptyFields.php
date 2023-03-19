<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Model\Validators;

use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use CrimsonAgility\ProductsRange\Api\ValidatorInterface;

/**
 * @inheritDoc
 */
class NoEmptyFields implements ValidatorInterface
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
        $highPrice = $params['high_price'] ?? null;
        $lowPrice = $params['low_price'] ?? null;
        $errors = [];

        if ($highPrice !== null || $lowPrice !== null) {
            $errors[] = __(
                'fields can not be empty for Search.'
            );
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

