<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\TextInputField;
use Luma\FormComponent\Form\FieldType\FieldType;
use PHPUnit\Framework\TestCase;

class FormFieldTest extends TestCase
{
    public function testTextInputField(): void
    {
        $textInputField = new TextInputField('username', 'Username');

        self::assertEquals('username', $textInputField->getName());
        self::assertEquals('Username', $textInputField->getLabel());
        self::assertEquals(FieldType::TEXT, $textInputField->getFieldType());
        self::assertEquals('text', $textInputField->getFieldType()->inputType());
    }

    public function testEmailInputField(): void
    {
        $textInputField = new EmailInputField('email', 'Email Address');

        self::assertEquals('email', $textInputField->getName());
        self::assertEquals('Email Address', $textInputField->getLabel());
        self::assertEquals(FieldType::EMAIL, $textInputField->getFieldType());
        self::assertEquals('email', $textInputField->getFieldType()->inputType());
    }
}