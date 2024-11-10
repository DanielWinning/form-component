<?php

namespace Tests\Tests\Form;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Field\AbstractFormField;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\Form as TestForm;
use Tests\Helpers\LoginForm;

class FormTest extends TestCase
{
    /**
     * @return void
     */
    public function testItInstantiates(): void
    {
        self::assertInstanceOf(AbstractForm::class, new TestForm());
    }

    /**
     * @return void
     */
    public function testRender(): void
    {
        self::assertIsString((new TestForm())->render());
        self::assertStringContainsString('<form method="POST">', (new TestForm())->render());
        self::assertStringContainsString('type="password"', (new LoginForm())->render());
    }

    /**
     * @return void
     */
    public function testGetFormFields(): void
    {
        $testForm = new TestForm();

        self::assertIsArray($testForm->getFormFields());
        self::assertInstanceOf(AbstractFormField::class, $testForm->getFormFields()[0]);
    }

    #[DataProvider('validationDataProvider')]
    public function testValidation(array $formData, int $errorCount, ?string $errorMessage, bool $expectedResult): void
    {
        $loginForm = new LoginForm($formData);

        self::assertEquals($expectedResult, $loginForm->validate());
        var_dump($loginForm->getData());
        self::assertSameSize($formData, $loginForm->getData());

        if ($errorCount) {
            self::assertEquals($errorMessage, $loginForm->getErrors()[0]);
        }
    }

    /**
     * @return array[]
     */
    public static function validationDataProvider(): array
    {
        return [
            'Required field is not included' => [
                'formData' => [
                    'email' => 'test@test.com',
                ],
                'errorCount' => 1,
                'errorMessage' => 'Password is required',
                'expectedResult' => false,
            ],
            'Password is too long' => [
                'formData' => [
                    'email' => 'test@test.com',
                    'password' => 'thisPasswordIsTooLongForThisRestriction',
                ],
                'errorCount' => 1,
                'errorMessage' => 'Password is too long, please limit your input to 16 characters or less',
                'expectedResult' => false,
            ],
            'Password does not meet minimum length requirements' => [
                'formData' => [
                    'email' => 'test@test.com',
                    'password' => 'tEst',
                ],
                'errorCount' => 1,
                'errorMessage' => 'Password must contain a minimum of 6 characters',
                'expectedResult' => false,
            ],
            'Password does not contain upper and lowercase letters' => [
                'formData' => [
                    'email' => 'test@test.com',
                    'password' => 'testing123',
                ],
                'errorCount' => 1,
                'errorMessage' => 'Password must contain upper and lowercase letters',
                'expectedResult' => false,
            ],
            'All fields are valid' => [
                'formData' => [
                    'email' => 'test@test.com',
                    'password' => 'Password123',
                ],
                'errorCount' => 0,
                'errorMessage' => null,
                'expectedResult' => true,
            ]
        ];
    }
}