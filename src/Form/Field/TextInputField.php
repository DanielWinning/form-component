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
        return sprintf(
            '<div><label for="%s">%s</label><input type="text" name="%s" id="%s" /></div>',
            $this->getId(),
            $this->getLabel(),
            $this->getName(),
            $this->getId()
        );
    }
}