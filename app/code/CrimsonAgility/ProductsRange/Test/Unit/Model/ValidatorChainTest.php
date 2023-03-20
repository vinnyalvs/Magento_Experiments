<?php
declare(strict_types=1);

namespace CrimsonAgility\ProductsRange\Test\Unit\Model;

use CrimsonAgility\ProductsRange\Model\ValidatorChain;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use PHPUnit\Framework\TestCase;
use CrimsonAgility\ProductsRange\Model\Validators\NoEmptyFields;

class ValidatorChainTest extends TestCase
{
    /**
     * @var ValidationResultFactory
     */
    private ValidationResultFactory $validationResultFactoryMock;

    /**
     * @var NoEmptyFields
     */
    private NoEmptyFields $exampleValidator;

    private array $validatorsMock;
    /**
     * @var ValidationResult $validationResultMock;
     */
    private ValidationResult $validationResultMock;

    /**
     * @var ValidatorChain $instance;
     */
    private ValidatorChain $instance;

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
        $this->exampleValidator = $this->createMock(NoEmptyFields::class);
        $this->validatorsMock = [$this->exampleValidator];
        $this->validationResultMock = $this->createMock(ValidationResult::class);
    }

    /**
     * Set Instance attribute
     * @throws LocalizedException
     */
    private function setInstance(): void
    {
        $this->instance = new ValidatorChain(
            $this->validationResultFactoryMock,
            $this->validatorsMock,
        );
    }
    /**
     * @test
     */
    public function testValidate()
    {
        $params = ['high_price' => 100.50, 'low_price' => 50.55];

        $this->exampleValidator
            ->expects($this->once())
            ->method('validate')
            ->with($params)
            ->willReturn($this->validationResulMock);

        $this->validationResulMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $this->validationResultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['errors' => []])
            ->willReturn($this->validationResulMock);

        $response = $this->instance->validate($params);

        $this->assertEmpty($response->getErrors());
    }

    /**
     * @test
     */
    public function testValidateWhenOneValidationFails()
    {
        $params = ['high_price' => 100.50, 'low_price' => 50.55];

        $error =
            ['ValidationError' => 'Validation Error Message'];

        $this->exampleValidator
            ->expects($this->once())
            ->method('validate')
            ->with($params)
            ->willReturn($this->validationResulMock);

        $this->validationResulMock
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $this->validationResulMock
            ->expects($this->exactly(2))
            ->method('getErrors')
            ->willReturn($error);

        $this->validationResultFactoryMock
            ->expects($this->once())
            ->method('create')
            ->with(['errors' => $error])
            ->willReturn($this->validationResulMock);

        $response = $this->instance->validate($params);

        $this->assertNotEmpty($response->getErrors());
    }
}
