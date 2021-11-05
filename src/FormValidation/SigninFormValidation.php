<?php
namespace App\FormValidation;

use App\FormValidation\ValidationInterface;
use App\Models\UserModel as User;

class SigninFormValidation extends FormValidation implements ValidationInterface
{
    protected static array $fields = ['firstName', 'lastName', 'email', 'password', 'password2'];

    public function validate(): array
    {
        foreach (self::$fields as $field) {
            if(!array_key_exists($field, $this->data)){
                trigger_error("$field is not present in this form...");
                return null;
            }
        }

        $this->validateFirstName();
        $this->validateLastName();
        $this->validateEmail();
        $this->validatePassword();

        return $this->errors;
    }

    private function validateFirstName(): void
    {
        $firstName = trim($this->data['firstName']);

        if(empty($firstName)) {
            $this->addError('firstName', 'This field is required');
        } else if(!preg_match("/^[A-Za-z]*(([,.] |[ '-])[A-Za-z][a-z]*)*(\.?)( [IVXLCDM]+)?$/",$firstName)){
            $this->addError('firstName', 'Please provide a valid first name.');
        }
    }

    private function validateLastName(): void
    {
        $lastName = trim($this->data['lastName']);

        if(empty($lastName)) {
            $this->addError('lastName', 'This field is required');
        } else if(!preg_match("/^[A-Za-z]*(([,.] |[ '-])[A-Za-z][a-z]*)*(\.?)( [IVXLCDM]+)?$/",$lastName)){
            $this->addError('lastName', 'Please provide a valid last name.');
        }
    }

    private function validateEmail(): void
    {
        $email = trim($this->data['email']);

        if(empty($email)) {
            $this->addError('email', 'Email field is required.');
        } else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $this->addError('email', 'You must enter a valid email.');
        } else {
            $user = new User;

            if($user->findOneByEmail($email) !== false) {
                $this->addError('email', 'This email is already in use.');
            }
        }
    }

    private function validatePassword(): void
    {
        $password = $this->data['password'];
        $password2 = $this->data['password2'];

        if(empty($password)) {
            $this->addError('password', 'Password cannot be empty.');
        } else if($password !== $password2) {
            $this->addError('password', 'Password do not match.');
        }
    }
}
