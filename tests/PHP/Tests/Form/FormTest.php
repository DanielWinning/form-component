<?php

namespace Tests\Tests\Form;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Field\AbstractFormField;
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
        self::assertStringContainsString('<form>', (new TestForm())->render());
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

    public function testValidation(): void
    {
        $loginForm = new LoginForm(null, [
            'email' => 'test@test.com',
            'password' => 'password123',
        ]);

        self::assertTrue($loginForm->validate());
        self::assertEmpty($loginForm->getErrors());

        $loginForm = new LoginForm(null, [
            'email' => 'test@test.com',
            'password' => '',
        ]);

        self::assertFalse($loginForm->validate());
        self::assertNotEmpty($loginForm->getErrors());
        self::assertEquals('Password is required', $loginForm->getErrors()[0]);

        $form = new TestForm(null, [
            'email' => 'test@test.com',
        ]);

        self::assertEquals('test@test.com', $form->getData()['email']);
        self::assertTrue($form->validate());

        $loginForm = new LoginForm(null, [
            'email' => 'test@test.com',
            'password' => 'thisisntarealisticlimitationonaloginfieldbutohwell',
        ]);

        self::assertFalse($loginForm->validate());
        self::assertNotEmpty($loginForm->getErrors());
        self::assertEquals('Password is too long, please limit your input to 16 characters or less', $loginForm->getErrors()[0]);
    }
}