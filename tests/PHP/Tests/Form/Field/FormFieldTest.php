<?php

namespace Tests\Tests\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\TextInputField;
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