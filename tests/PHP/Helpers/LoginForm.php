<?php

namespace Tests\Helpers;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\AbstractFormField;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\PasswordInputField;
use Luma\FormComponent\Form\Field\SubmitButton;

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
            'validation' => function (AbstractForm $form, AbstractFormField $thisField) {
                return $thisField->getValue() === 'test@test.com';
            }
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'password',
            'id' => 'password',
            'label' => 'Password',
            'required' => true,
            'minLength' => 6,
            'maxLength' => 16,
            'validation' => function (AbstractForm $form, AbstractFormField $thisField) {
                $hasUpperCase = preg_match('/[A-Z]/', $thisField->getValue() ?? '');
                $hasLowerCase = preg_match('/[a-z]/', $thisField->getValue() ?? '');

                return $hasLowerCase && $hasUpperCase;
            },
            'validationError' => '%s must contain upper and lowercase letters',
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'optional',
            'id' => 'optional',
            'label' => 'Optional',
        ]));
        $this->addFormField(new SubmitButton([
            'name' => 'Log In',
            'id' => 'login-submit',
        ]));
    }
}