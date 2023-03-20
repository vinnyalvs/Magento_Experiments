<?php
declare(strict_types=1);
namespace CrimsonAgility\ProductsRange\Api;
use Magento\Framework\Validation\ValidationResult;

/**
 * Structure to check if a set of attributes are valid
 */
interface ValidatorInterface
{

    /**
     * Validate if a set of attributes are valid
     *
     * @param array $params
     * @return ValidationResult
     */
    public function validate(array $params): ValidationResult;
}
