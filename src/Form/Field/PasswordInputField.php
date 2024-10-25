<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\FieldType\FieldType;

class PasswordInputField extends AbstractFormField
{
    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->fieldType = FieldType::PASSWORD;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->getDefaultInputHtml();
    }
}