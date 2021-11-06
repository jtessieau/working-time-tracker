<?php

namespace App\FormValidation;

use App\FormValidation\ValidationInterface;
use App\FormValidation\FormValidation;

class LoginFormValidation extends FormValidation implements ValidationInterface
{
    protected static array $fields = ['email', 'password'];

    public function validate(): array
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not present in this form...");
                return null;
            }
        }

        $this->validateEmail();
        $this->validatePassword();

        return $this->errors;
    }

    private function validateEmail(): void
    {
        $email = trim($this->data['email']);

        if (empty($email)) {
            $this->addError('email', 'Email field is required.');
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email', 'You must enter a valid email.');
        }
    }

    private function validatePassword(): void
    {
        $password = $this->data['password'];

        if (empty($password)) {
            $this->addError('password', 'Password cannot be empty.');
        }
    }
}
