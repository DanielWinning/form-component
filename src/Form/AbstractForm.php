<?php

namespace Luma\FormComponent\Form;

use Latte\Engine;
use Luma\FormComponent\Form\Field\AbstractFormField;
use Luma\FormComponent\Form\Interface\FormInterface;

abstract class AbstractForm implements FormInterface
{
    protected Engine $templateEngine;

    /**
     * @var AbstractFormField[]
     */
    protected array $formFields = [];
    protected array $errors = [];
    protected string $method = 'POST';

    public function __construct(protected array $data = [])
    {
        $this->templateEngine = new Engine();
        $this->build();
        $this->populateData();
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

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    abstract protected function build(): void;

    /**
     * @return array
     */
    public function getFormFields(): array
    {
        return $this->formFields;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return $this->method;
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

    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->formFields as $field) {
            if (!$field->validate($this)) {
                $this->errors = array_merge($this->errors, $field->getErrors());
            }
        }

        return empty($this->errors);
    }

    /**
     * @return void
     */
    private function populateData(): void
    {
        foreach ($this->formFields as $field) {
            if (array_key_exists($field->getName(), $this->data)) {
                $field->setValue($this->data[$field->getName()]);
            }
        }
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}