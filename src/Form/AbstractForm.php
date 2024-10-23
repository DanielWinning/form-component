<?php

namespace Luma\FormComponent\Form;

use Latte\Engine;
use Luma\FormComponent\Form\Field\AbstractFormField;
use Luma\FormComponent\Form\Interface\FormInterface;

abstract class AbstractForm implements FormInterface
{
    protected Engine $templateEngine;
    protected array $formFields = [];

    public function __construct()
    {
        $this->templateEngine = new Engine();
        $this->build();
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $formTemplate = sprintf('%s/views/form.latte', dirname(__DIR__, 2));

        return $this->templateEngine->renderToString($formTemplate, [
            'form' => $this,
        ]);
    }

    abstract protected function build(): void;

    /**
     * @return AbstractFormField[]
     */
    public function getFormFields(): array
    {
        return $this->formFields;
    }

    /**
     * @param AbstractFormField $formField
     *
     * @return void
     */
    protected function addFormField(AbstractFormField $formField): void
    {
        $this->formFields[] = $formField;
    }
}