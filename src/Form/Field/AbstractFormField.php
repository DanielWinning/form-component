<?php

namespace Luma\FormComponent\Form\Field;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\FieldType\FieldType;
use Luma\FormComponent\Form\Interface\FormFieldInterface;

abstract class AbstractFormField implements FormFieldInterface
{
    /**
     * @var array<string, string>
     */
    protected array $requiredOptions = [
        'id' => 'string',
        'label' => 'string',
        'name' => 'string',
    ];
    /**
     * @var array<string, string>
     */
    protected array $validOptions = [
        'classes' => 'string',
        'containerClasses' => 'string',
        'maxLength' => 'integer',
        'minLength' => 'integer',
        'required' => 'boolean',
        'placeholder' => 'string',
        'validation' => 'object',
        'validationError' => 'string',
    ];
    protected FieldType $fieldType;
    protected mixed $value = null;

    /**
     * @var array<int, string>
     */
    protected array $errors = [];
    protected bool $shouldValidate = true;

    /**
     * @param array<string, string|int|bool|object> $options
     *
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
     * @return string
     */
    public function getContainerClasses(): string
    {
        return array_key_exists('containerClasses', $this->options)
            ? $this->options['containerClasses']
            : '';
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue(mixed $value): void
    {
        $this->value = $value;
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
    public function getMinLength(): ?int
    {
        return array_key_exists('minLength', $this->options)
            ? (int) $this->options['minLength']
            : null;
    }

    /**
     * @return int|null
     */
    public function getMaxLength(): ?int
    {
        return array_key_exists('maxLength', $this->options)
            ? (int) $this->options['maxLength']
            : null;
    }

    /**
     * @return string|null
     */
    public function getPlaceholder(): ?string
    {
        return array_key_exists('placeholder', $this->options)
            ? (string) $this->options['placeholder']
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

        $validOptions = array_merge($this->validOptions, $this->requiredOptions);

        foreach ($this->options as $key => $option) {
            if (!array_key_exists($key, $validOptions)) {
                throw new InvalidFieldOptionException($key);
            }

            if (gettype($option) !== $validOptions[$key]) {
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
            '<div%s><label for="%s">%s</label><input type="%s" name="%s" id="%s" %s%s%s%s%s%s/></div>',
            !empty($this->getContainerClasses()) ? sprintf(' class="%s"', $this->getContainerClasses()) : '',
            $this->getId(),
            $this->getLabel(),
            $this->getFieldType()->inputType(),
            $this->getName(),
            $this->getId(),
            !empty($this->getClasses()) ? sprintf('class="%s" ', $this->getClasses()) : '',
            $this->isRequired() ? 'required ' : '',
            $this->getMinLength() ? sprintf('minlength="%s" ', $this->getMinLength()) : '',
            $this->getMaxLength() ? sprintf('maxlength="%s" ', $this->getMaxLength()) : '',
            $this->getValue() ? sprintf('value="%s"', $this->value) : '',
            $this->getPlaceholder() ? sprintf('placeholder="%s"', $this->getPlaceholder()) : ''
        );
    }

    /**
     * @return array<int, string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    abstract public function getHtml(): string;

    /**
     * @param AbstractForm $form
     *
     * @return bool
     */
    public function validate(AbstractForm $form): bool
    {
        if (!$this->shouldValidate) {
            return true;
        }

        if ($this->isRequired() && !$this->getValue()) {
            $this->errors[] = sprintf('%s is required', $this->getLabel());
        }

        if (isset($this->options['validation'])) {
            if (!$this->options['validation']($form, $this)) {
                $this->errors[] = sprintf(
                    '%s',
                    $this->options['validationError']
                        ? sprintf($this->options['validationError'], $this->getLabel())
                        : sprintf('Error handling %s', $this->getLabel())
                );
            }
        }

        if (!$this->getValue() && !count($this->errors)) {
            return true;
        }

        if ($this->getMinLength() && strlen((string) $this->getValue()) < $this->getMinLength()) {
            $this->errors[] = sprintf(
                '%s must contain a minimum of %d characters',
                $this->getLabel(),
                $this->getMinLength()
            );
        }

        if ($this->getMaxLength() && strlen((string) $this->getValue()) > $this->getMaxLength()) {
            $this->errors[] = sprintf(
                '%s is too long, please limit your input to %d characters or less',
                $this->getLabel(),
                $this->getMaxLength()
            );
        }

        if (count($this->errors)) {
            return false;
        }

        return true;
    }
}