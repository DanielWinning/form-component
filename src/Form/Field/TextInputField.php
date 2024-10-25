<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\FieldType\FieldType;

class TextInputField extends AbstractFormField
{
    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->fieldType = FieldType::TEXT;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return $this->getDefaultInputHtml();
    }
}