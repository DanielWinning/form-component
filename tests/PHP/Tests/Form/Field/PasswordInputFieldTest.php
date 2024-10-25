<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\PasswordInputField;
use Luma\FormComponent\Form\FieldType\FieldType;
use PHPUnit\Framework\TestCase;

class PasswordInputFieldTest extends TestCase
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testWithValidOptions(): void
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

    public function testGetHtml(): void
    {
        $inputField = new PasswordInputField([
            'name' => 'password',
            'label' => 'Password',
            'id' => 'password',
        ]);
        $inputFieldHtml = $inputField->getHtml();

        self::assertStringContainsString('type="password"', $inputFieldHtml);
        self::assertStringContainsString('name="password"', $inputFieldHtml);
        self::assertStringContainsString('id="password"', $inputFieldHtml);
        self::assertStringContainsString('<label for="password">Password</label>', $inputFieldHtml);
    }
}