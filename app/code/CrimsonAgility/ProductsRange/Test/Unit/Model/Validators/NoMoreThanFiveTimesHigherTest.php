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

use CrimsonAgility\ProductsRange\Model\Validators\NoMoreThanFiveTimesHigher;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use PHPUnit\Framework\TestCase;

class NoMoreThanFiveTimesHigherTest extends TestCase
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
     * @var NoMoreThanFiveTimesHigher $instance;
     */
    private NoMoreThanFiveTimesHigher $instance;

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
        $this->instance = new NoMoreThanFiveTimesHigher(
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
        $params = ['high_price' => 500, 'low_price' => 50];

        $errors[] =  __(
            'High Price can be no more than 5x higher than the entered "Low Price.'
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
