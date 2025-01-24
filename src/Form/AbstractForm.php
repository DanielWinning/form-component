<?php

namespace Luma\FormComponent\Form;

use Latte\Engine;
use Luma\FormComponent\Form\Field\AbstractFormField;
use Luma\FormComponent\Form\Field\SubmitButton;
use Luma\FormComponent\Form\Interface\FormInterface;

abstract class AbstractForm implements FormInterface
{
    protected Engine $templateEngine;

    /**
     * @var AbstractFormField[]
     */
    protected array $formFields = [];
    /**
     * @var array<int, string>
     */
    protected array $errors = [];
    protected string $method = 'POST';

    /**
     * @param array<string, mixed> $data
     */
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
     * @return array<int, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    abstract protected function build(): void;

    /**
     * @return array<int, AbstractFormField>
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
        $data = [];

        foreach ($this->formFields as $field) {
            if ($field instanceof SubmitButton) {
                continue;
            }

            if (array_key_exists($field->getName(), $this->data)) {
                $field->setValue($this->data[$field->getName()]);
                $data[$field->getName()] = $field->getValue();
            } else {
                $data[$field->getName()] = null;
            }
        }

        $this->data = $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param string $fieldName
     *
     * @return string|array<string, string>|null
     */
    public function getField(string $fieldName): string|array|null
    {
        if (array_key_exists($fieldName, $this->data)) {
            return $this->data[$fieldName];
        }

        return null;
    }
}