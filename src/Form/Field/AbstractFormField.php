<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\FieldType\FieldType;
use Luma\FormComponent\Form\Interface\FormFieldInterface;

abstract class AbstractFormField implements FormFieldInterface
{
    private array $requiredOptions = ['id', 'label', 'name'];
    private array $validOptions = ['classes', 'id', 'label', 'name'];
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
     * @return FieldType
     */
    public function getFieldType(): FieldType
    {
        return $this->fieldType;
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
            if (!in_array($key, $this->validOptions)) {
                throw new InvalidFieldOptionException($key);
            }
        }
    }

    /**
     * @return void
     *
     * @throws MissingFieldOptionException
     */
    private function checkForRequiredOptions(): void
    {
        foreach ($this->requiredOptions as $requiredOption) {
            if (!array_key_exists($requiredOption, $this->options)) {
                throw new MissingFieldOptionException($requiredOption);
            }
        }
    }

    /**
     * @return string
     */
    abstract public function getHtml(): string;
}