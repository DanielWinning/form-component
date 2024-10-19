<?php

namespace Tests\Tests\Form;

use Luma\FormComponent\Form\AbstractFormField;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\FormField as TestFormField;

class FormFieldTest extends TestCase
{
    public function testItInstantiates(): void
    {
        self::assertInstanceOf(AbstractFormField::class, new TestFormField());
    }

    public function testGetters(): void
    {
        $formField = new TestFormField();

        self::assertEquals('test-form-field', $formField->getName());
    }
}