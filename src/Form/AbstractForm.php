<?php

namespace Luma\FormComponent\Form;

use Luma\FormComponent\Form\Interface\FormInterface;

class AbstractForm implements FormInterface
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