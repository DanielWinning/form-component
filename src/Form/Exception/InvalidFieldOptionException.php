<?php

namespace Luma\FormComponent\Form\Exception;

class InvalidFieldOptionException extends \Exception
{
    public function __construct(string $invalidOption)
    {
        parent::__construct(sprintf('You have passed an invalid form field option: %s', $invalidOption));
    }
}