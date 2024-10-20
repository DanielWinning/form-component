<?php

namespace Tests\Helpers;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Field\TextInputField;

class Form extends AbstractForm
{
    protected function build(): void
    {
        $this->addFormField(new TextInputField('username', 'Username'));
    }
}