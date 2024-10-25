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
}