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

namespace CrimsonAgility\ProductsRange\Test\Model\Validators;

use CrimsonAgility\ProductsRange\Model\Validators\NoNegativeOrZeroFields;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use PHPUnit\Framework\TestCase;

class NoNegativeOrZeroFieldsTest extends TestCase
{

    /**
     * @var ValidationResultFactory $validationResultFactory
     */

    private ValidationResultFactory $validationResultFactoryMock;

    /**
     * @var ValidationResult
     */
    private ValidationResult $validationResultMock;

    /**
     * @var NoNegativeOrZeroFields $instance;
     */
    private NoNegativeOrZeroFields $instance;

    /**
     * Test setup
     * @throws LocalizedException
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
        $this->validationResultFactoryMock = $this->createMock(ValidationResultFactory::class);
        $this->validationResultMock = $this->createMock(ValidationResult::class);

    }

    /**
     * Set Instance attribute
     */
    private function setInstance(): void
    {
        $this->instance = new NoNegativeOrZeroFields(
            $this->validationResultFactoryMock,
        );
    }
    public function testValidate()
    {
        $params = ['high_price' => 100.50, 'low_price' => 50.55];

        $errors = [];

        $this->validationResultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['errors' => $errors])
            ->willReturn($this->validationResultMock);

        $this->validationResultMock
            ->expects($this->once())
            ->method('getErrors')
            ->willReturn($errors);

        $result = $this->instance->validate($params);

        $this->assertEmpty($result->getErrors());
    }

    public function testValidateWithError()
    {
        $params = ['high_price' => -100.50, 'low_price' => 0];

        $errors[] =  __(
            'High price can not be zero or negative.'
        );

        $this->validationResultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['errors' => $errors])
            ->willReturn($this->validationResultMock);

        $this->validationResultMock
            ->expects($this->once())
            ->method('getErrors')
            ->willReturn($errors);

        $result = $this->instance->validate($params);

        $this->assertNotEmpty($result->getErrors());
    }
}
