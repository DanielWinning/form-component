<?php

namespace Luma\FormComponent\Form;

use Luma\FormComponent\Form\Interface\FormFieldInterface;

class AbstractFormField implements FormFieldInterface
{
    protected string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}