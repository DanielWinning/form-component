<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\TextInputField;
use Luma\FormComponent\Form\FieldType\FieldType;
use PHPUnit\Framework\TestCase;

class FormFieldTest extends TestCase
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testFormFieldWithInvalidOptions(): void
    {
        self::expectException(InvalidFieldOptionException::class);

        new TextInputField([
            'id' => 'test',
            'name' => 'test',
            'label' => 'test',
            'no-display' => true,
        ]);
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testFormFieldWithMissingOption(): void
    {
        self::expectException(MissingFieldOptionException::class);

        new TextInputField([
           'name' => 'test',
           'label' => 'test',
        ]);
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testTextInputFieldWithValidOptions(): void
    {
        $inputField = new TextInputField([
            'name' => 'username',
            'label' => 'Username',
            'id' => 'username-input',
        ]);

        self::assertEquals('username', $inputField->getName());
        self::assertEquals('Username', $inputField->getLabel());
        self::assertEquals('username-input', $inputField->getId());
        self::assertEquals(FieldType::TEXT, $inputField->getFieldType());
        self::assertEquals('text', $inputField->getFieldType()->inputType());
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testEmailInputFieldWithValidOptions(): void
    {
        $inputField = new EmailInputField([
            'name' => 'email',
            'label' => 'Email Address',
            'id' => 'email-input',
        ]);

        self::assertEquals('email', $inputField->getName());
        self::assertEquals('Email Address', $inputField->getLabel());
        self::assertEquals('email-input', $inputField->getId());
        self::assertEquals(FieldType::EMAIL, $inputField->getFieldType());
        self::assertEquals('email', $inputField->getFieldType()->inputType());
    }
}