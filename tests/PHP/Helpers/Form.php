<?php

namespace Tests\Helpers;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\AbstractFormField;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\TextInputField;

class Form extends AbstractForm
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    protected function build(): void
    {
        $this->addFormField(new TextInputField([
            'name' => 'username',
            'label' => 'Username',
            'id' => 'username-input',
        ]));
        $this->addFormField(new EmailInputField([
            'name' => 'email',
            'label' => 'Email Address',
            'id' => 'email-input',
        ]));
    }
}