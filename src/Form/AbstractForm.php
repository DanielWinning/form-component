<?php

namespace Luma\FormComponent\Form;

use Latte\Engine;
use Luma\FormComponent\Form\Interface\FormInterface;

abstract class AbstractForm implements FormInterface
{
    protected Engine $templateEngine;

    public function __construct()
    {
        $this->templateEngine = new Engine();
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $formTemplate = sprintf('%s/views/form.latte', dirname(__DIR__, 2));

        return $this->templateEngine->renderToString($formTemplate);
    }
}