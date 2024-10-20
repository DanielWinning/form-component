<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\FieldType\FieldType;
use Luma\FormComponent\Form\Interface\FormFieldInterface;

abstract class AbstractFormField implements FormFieldInterface
{
    protected FieldType $fieldType;

    public function __construct(
        protected string $name,
        protected string $label
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return FieldType
     */
    public function getFieldType(): FieldType
    {
        return $this->fieldType;
    }
}