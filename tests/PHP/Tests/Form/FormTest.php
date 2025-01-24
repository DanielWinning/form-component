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
        self::assertStringContainsString('<form method="POST">', (new TestForm())->render());
        self::assertStringContainsString('type="password"', (new LoginForm())->render());
    }

    /**
     * @return void
     */
    public function testGetFormFields(): void
    {
        $testForm = new TestForm();

        self::assertInstanceOf(AbstractFormField::class, $testForm->getFormFields()[0]);
    }

    /**
     * @param array<string, int|string> $formData
     * @param int $errorCount
     * @param string|null $errorMessage
     * @param bool $expectedResult
     *
     * @return void
     */
    #[DataProvider('validationDataProvider')]
    public function testValidation(array $formData, int $errorCount, ?string $errorMessage, bool $expectedResult): void
    {
        $loginForm = new LoginForm($formData);

        self::assertEquals($expectedResult, $loginForm->validate());

        if ($errorCount) {
            self::assertEquals($errorMessage, $loginForm->getErrors()[0]);
        }
    }

    /**
     * @param array $data
     * @param array $expected
     *
     * @return void
     */
    #[DataProvider('getDataDataProvider')]
    public function testGetData(array $data, array $expected): void
    {
        $loginForm = new LoginForm($data);

        self::assertEquals($expected, $loginForm->getData());
    }

    /**
     * @param array $data
     * @param string $fieldName
     * @param string|null $expected
     *
     * @return void
     */
    #[DataProvider('getFieldDataProvider')]
    public function testGetField(array $data, string $fieldName, ?string $expected): void
    {
        $loginForm = new LoginForm($data);

        self::assertEquals($expected, $loginForm->getField($fieldName));
    }

    /**
     * @return array<string, array>
     */
    public static function getFieldDataProvider(): array
    {
        return [
            'Empty form data' => [
                'data' => [],
                'fieldName' => 'email',
                'expected' => null,
            ],
            'Submitted form data' => [
                'data' => [
                    'email' => 'test@example.com',
                    'password' => 'password',
                ],
                'fieldName' => 'email',
                'expected' => 'test@example.com',
            ],
            'Requesting non-existent form field' => [
                'data' => [
                    'email' => 'test@example.com',
                    'password' => 'password',
                ],
                'fieldName' => 'customer',
                'expected' => null,
            ],
        ];
    }

    /**
     * @return array
     */
    public static function getDataDataProvider(): array
    {
        return [
            'Submitted with unrelated fields' => [
                'data' => [
                    'email' => 'test@test.com',
                    'customer' => 'Test Customer',
                ],
                'expected' => [
                    'email' => 'test@test.com',
                    'password' => null,
                    'optional' => null,
                ],
            ],
            'Submitted with all required fields' => [
                'data' => [
                    'email' => 'test@test.com',
                    'password' => 'password1234',
                    'optional' => 'test',
                ],
                'expected' => [
                    'email' => 'test@test.com',
                    'password' => 'password1234',
                    'optional' => 'test',
                ],
            ],
        ];
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