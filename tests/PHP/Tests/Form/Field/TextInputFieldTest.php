<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\TextInputField;
use Luma\FormComponent\Form\FieldType\FieldType;
use PHPUnit\Framework\TestCase;

class TextInputFieldTest extends TestCase
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function testWithValidOptions(): void
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
    public function testGetHtml(): void
    {
        $inputField = new TextInputField([
            'name' => 'username',
            'label' => 'Username',
            'id' => 'username-input',
        ]);
        $inputFieldHtml = $inputField->getHtml();

        self::assertStringContainsString('type="text"', $inputFieldHtml);
        self::assertStringContainsString('name="username"', $inputFieldHtml);
        self::assertStringContainsString('<label for="username-input">', $inputFieldHtml);
        self::assertStringNotContainsString('required', $inputFieldHtml);
        self::assertStringNotContainsString('class', $inputFieldHtml);

        $inputField = new TextInputField([
            'name' => 'username',
            'label' => 'Username',
            'id' => 'username-input',
            'required' => true,
            'classes' => 'test-class',
        ]);
        $inputFieldHtml = $inputField->getHtml();

        self::assertStringContainsString('required', $inputFieldHtml);
        self::assertStringContainsString('class="test-class"', $inputFieldHtml);
    }
}