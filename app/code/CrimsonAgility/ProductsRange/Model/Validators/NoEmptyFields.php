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
        $errors = [];

        if ( !isset($params['high_price']) || !isset($params['low_price']) ) {
            $errors[] = __(
                'fields can not be empty for Search.'
            );
        }

        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}

