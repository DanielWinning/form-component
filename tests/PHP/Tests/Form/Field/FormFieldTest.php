<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\PasswordInputField;
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
            'required' => true,
            'maxLength' => 255,
        ]);

        self::assertEquals('email', $inputField->getName());
        self::assertEquals('Email Address', $inputField->getLabel());
        self::assertEquals('email-input', $inputField->getId());
        self::assertEquals(FieldType::EMAIL, $inputField->getFieldType());
        self::assertEquals('email', $inputField->getFieldType()->inputType());
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testPasswordInputFieldWithValidOptions(): void
    {
        $inputField = new PasswordInputField([
            'name' => 'password',
            'label' => 'Password',
            'id' => 'password',
            'required' => true,
        ]);

        self::assertEquals('password', $inputField->getName());
        self::assertEquals('Password', $inputField->getLabel());
        self::assertEquals('password', $inputField->getId());
        self::assertEquals(FieldType::PASSWORD, $inputField->getFieldType());
        self::assertEquals('password', $inputField->getFieldType()->inputType());
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testFormFieldWithInvalidOptionalOptionTypes(): void
    {
        self::expectException(InvalidFieldOptionException::class);

        new TextInputField([
            'name' => 'test',
            'label' => 'Test',
            'id' => 'test',
            'required' => 'true',
        ]);
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testFormFieldWithInvalidRequiredOptionTypes(): void
    {
        self::expectException(InvalidFieldOptionException::class);

        new TextInputField([
            'name' => 'test',
            'label' => 'Test',
            'id' => 1,
            'required' => true,
        ]);
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testOptionalGetters(): void
    {
        $textInputField = new TextInputField([
            'name' => 'test',
            'id' => 'test',
            'label' => 'Test',
        ]);

        self::assertEquals('', $textInputField->getClasses());
        self::assertFalse($textInputField->isRequired());

        $textInputField = new TextInputField([
            'name' => 'test',
            'id' => 'test',
            'label' => 'Test',
            'classes' => 'custom class-list',
            'required' => false,
        ]);

        self::assertEquals('custom class-list', $textInputField->getClasses());
        self::assertFalse($textInputField->isRequired());
        self::assertNull($textInputField->getMaxLength());

        $textInputField = new TextInputField([
            'name' => 'test',
            'id' => 'test',
            'label' => 'Test',
            'required' => true,
            'maxLength' => 255,
        ]);

        self::assertTrue($textInputField->isRequired());
        self::assertEquals(255, $textInputField->getMaxLength());
    }
}