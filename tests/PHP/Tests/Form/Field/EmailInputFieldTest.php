<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\FieldType\FieldType;
use PHPUnit\Framework\TestCase;

class EmailInputFieldTest extends TestCase
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testValidOptions(): void
    {
        $inputField = new EmailInputField([
            'name' => 'email',
            'label' => 'Email Address',
            'id' => 'email-input',
            'required' => true,
            'maxLength' => 255,
            'placeholder' => 'example@email.com',
            'validation' => function () {
                return true;
            }
        ]);

        self::assertEquals('email', $inputField->getName());
        self::assertEquals('Email Address', $inputField->getLabel());
        self::assertEquals('email-input', $inputField->getId());
        self::assertEquals(FieldType::EMAIL, $inputField->getFieldType());
        self::assertEquals('email', $inputField->getFieldType()->inputType());
        self::assertEquals('example@email.com', $inputField->getPlaceholder());
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testGetHtml(): void
    {
        $inputField = new EmailInputField([
            'name' => 'emailAddress',
            'label' => 'Email Address',
            'id' => 'email',
            'required' => true,
        ]);
        $inputFieldHtml = $inputField->getHtml();

        self::assertStringContainsString('id="email"', $inputFieldHtml);
        self::assertStringContainsString('name="emailAddress"', $inputFieldHtml);
        self::assertStringContainsString('<label for="email">Email Address</label>', $inputFieldHtml);
    }
}