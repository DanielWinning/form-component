<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Field\TextInputField;
use Luma\FormComponent\Form\FieldType\FieldType;
use PHPUnit\Framework\TestCase;

class FormFieldTest extends TestCase
{
    public function testGetters(): void
    {
        $textInputField = new TextInputField('username', 'Username');

        self::assertEquals('username', $textInputField->getName());
        self::assertEquals('Username', $textInputField->getLabel());
        self::assertEquals(FieldType::TEXT, $textInputField->getFieldType());
        self::assertEquals('text', $textInputField->getFieldType()->inputType());
    }
}