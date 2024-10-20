<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\FieldType\FieldType;

class TextInputField extends AbstractFormField
{
    public function __construct(string $name, string $label)
    {
        parent::__construct($name, $label);
        $this->fieldType = FieldType::TEXT;
    }
}