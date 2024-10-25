<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\FieldType\FieldType;
use Luma\FormComponent\Form\Interface\FormFieldInterface;

abstract class AbstractFormField implements FormFieldInterface
{
    private array $requiredOptions = [
        'id' => 'string',
        'label' => 'string',
        'name' => 'string',
    ];
    private array $validOptions = [
        'classes' => 'string',
        'id' => 'string',
        'label' => 'string',
        'name' => 'string',
        'required' => 'boolean',
        'maxLength' => 'integer',
    ];
    protected FieldType $fieldType;

    /**
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    public function __construct(protected array $options)
    {
        $this->validateOptions();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->options['name'];
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->options['label'];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->options['id'];
    }

    /**
     * @return string
     */
    public function getClasses(): string
    {
        return array_key_exists('classes', $this->options)
            ? $this->options['classes']
            : '';
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return array_key_exists('required', $this->options)
            ? $this->options['required']
            : false;
    }

    /**
     * @return FieldType
     */
    public function getFieldType(): FieldType
    {
        return $this->fieldType;
    }

    /**
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return array_key_exists('maxLength', $this->options)
            ? $this->options['maxLength']
            : null;
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    private function validateOptions(): void
    {
        $this->checkForRequiredOptions();

        foreach ($this->options as $key => $option) {
            if (!array_key_exists($key, $this->validOptions)) {
                throw new InvalidFieldOptionException($key);
            }

            if (gettype($option) !== $this->validOptions[$key]) {
                throw new InvalidFieldOptionException($key);
            }
        }
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    private function checkForRequiredOptions(): void
    {
        foreach ($this->requiredOptions as $requiredOption => $optionType) {
            if (!array_key_exists($requiredOption, $this->options)) {
                throw new MissingFieldOptionException($requiredOption);
            }

            if (gettype($this->options[$requiredOption]) !== $optionType) {
                throw new InvalidFieldOptionException($requiredOption);
            }
        }
    }

    /**
     * @return string
     */
    protected function getDefaultInputHtml(): string
    {
        return sprintf(
            '<div><label for="%s">%s</label><input type="%s" name="%s" id="%s" %s /></div>',
            $this->getId(),
            $this->getLabel(),
            $this->getFieldType()->inputType(),
            $this->getName(),
            $this->getId(),
            !empty($this->getClasses()) ? sprintf('class="%s"', $this->getClasses()) : '',
        );
    }

    /**
     * @return string
     */
    abstract public function getHtml(): string;
}