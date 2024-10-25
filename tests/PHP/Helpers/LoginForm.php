<?php

namespace Tests\Helpers;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\PasswordInputField;

class LoginForm extends AbstractForm
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    protected function build(): void
    {
        $this->addFormField(new EmailInputField([
            'name' => 'email',
            'id' => 'email',
            'label' => 'Email Address',
            'required' => true,
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'password',
            'id' => 'password',
            'label' => 'Password',
            'required' => true,
        ]));
    }
}