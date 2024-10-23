<?php

namespace Luma\FormComponent\Form\Exception;

class MissingFieldOptionException extends \Exception
{
    public function __construct(string $missingOption)
    {
        parent::__construct(sprintf('Form field is missing required option: %s', $missingOption));
    }
}