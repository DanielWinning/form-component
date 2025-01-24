<?php

namespace Luma\FormComponent\Form\Field;

class SubmitButton extends AbstractFormField
{
    protected array $validOptions = [
        'classes' => 'string',
        'containerClasses' => 'string',
    ];
    protected bool $shouldValidate = false;

    /**
     * @return string
     */
    public function getHtml(): string
    {
        return sprintf(
            '<div%s><input type="submit" value="%s" id="%s"%s/></div>',
            $this->getContainerClasses() ? sprintf('class="%s"', $this->getContainerClasses()) : '',
            $this->getName(),
            $this->getId(),
            $this->getClasses() ? sprintf(' class="%s"', $this->getClasses()) : '',
        );
    }
}