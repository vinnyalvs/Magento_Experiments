<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 *
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2023 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Model;

use CrimsonAgility\ProductsRange\Api\ValidatorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;

/**
 * @inheritdoc
 */
class ValidatorChain implements ValidatorInterface
{
    /**
     * Validator chain constructor
     *
     * @param ValidationResultFactory $validationResultFactory
     * @param ValidatorInterface[] $validators
     *
     * @throws LocalizedException
     */
    public function __construct(
        private readonly ValidationResultFactory $validationResultFactory,
        private readonly array                   $validators
    ) {
        foreach ($validators as $validator) {
            if (!$validator instanceof ValidatorInterface) {
                throw new LocalizedException(
                    __('Validator must implement ValidatorInterface.')
                );
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function validate(array $params): ValidationResult
    {
        $errors = [[]];
        foreach ($this->validators as $validator) {
            $validationResult = $validator->validate($params);

            if (!$validationResult->isValid()) {
                $errors[] = $validationResult->getErrors();
            }
        }

        $errors = array_merge(...$errors);
        return $this->validationResultFactory->create(['errors' => $errors]);
    }
}
