<?php

namespace Luma\FormComponent\Form\FieldType;

enum FieldType
{
    case EMAIL;
    case PASSWORD;
    case TEXT;
    case SUBMIT;

    public function inputType(): string
    {
        return match($this) {
            FieldType::EMAIL => 'email',
            FieldType::PASSWORD => 'password',
            FieldType::TEXT => 'text',
            FieldType::SUBMIT => 'submit',
        };
    }
}