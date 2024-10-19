<?php

namespace Tests\Tests\Form;

use Luma\FormComponent\Form\AbstractForm;
use PHPUnit\Framework\TestCase;
use Tests\Helpers\Form as TestForm;

class FormTest extends TestCase
{
    public function testItInstantiates(): void
    {
        self::assertInstanceOf(AbstractForm::class, new TestForm());
    }

    public function testGetters(): void
    {
        $form = new TestForm();

        self::assertEquals('test-form', $form->getName());
    }
}