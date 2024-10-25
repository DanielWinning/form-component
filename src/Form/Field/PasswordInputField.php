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
        return sprintf(
            '<div><label for="%s">%s</label><input type="password" name="%s" id="%s" %s/></div>',
            $this->getId(),
            $this->getLabel(),
            $this->getName(),
            $this->getId(),
            $this->isRequired() ? 'required' : ''
        );
    }
}