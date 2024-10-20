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
        self::assertIsString((new TestForm())->render());
    }
}