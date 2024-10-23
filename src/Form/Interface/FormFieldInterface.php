<?php

namespace Luma\FormComponent\Form\Interface;

interface FormFieldInterface
{
    public function getName(): string;
    public function getLabel(): string;
    public function getHtml(): string;
}