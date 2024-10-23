<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\FieldType\FieldType;

class EmailInputField extends AbstractFormField
{
    public function __construct(array $options)
    {
        parent::__construct($options);
        $this->fieldType = FieldType::EMAIL;
    }

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return sprintf(
            '<div><label for="%s">%s</label><input type="email" name="%s" id="%s" /></div>',
            $this->getId(),
            $this->getLabel(),
            $this->getName(),
            $this->getId()
        );
    }
}