<?php

namespace App\FormValidation;

class FormValidation
{
    protected array $data;
    protected array $errors = [];
    protected static array $fields = [];

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }

    protected function addError(string $field, string $errorMessage): void
    {
        $this->errors[$field] = $errorMessage;
    }
}
