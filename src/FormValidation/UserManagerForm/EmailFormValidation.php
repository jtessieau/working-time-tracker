<?php

namespace App\FormValidation\UserManagerForm;

use App\FormValidation\FormValidation;
use App\FormValidation\ValidationInterface;
use App\Models\UserModel;

class EmailFormValidation extends FormValidation implements ValidationInterface
{
    public function validate(): array
    {
        $email = $this->data['email'];
        $emailConfirmation = $this->data['emailConfirmation'];

        $userModel = new UserModel();

        if (empty($email)) {
            $this->addError('email', 'Email address must be set.');
        } elseif ($email !== $emailConfirmation) {
            $this->addError('email', 'Email address must match.');
        } elseif ($email === $_SESSION['user']['email']) {
            $this->addError('email', 'Email address must be different than current address.');
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->addError('email', 'Please enter a valide email address.');
        } elseif (!is_null($userModel->findOneByEmail($email))) {
            $this->addError('email', 'You can not use this email address.');
        }

        return $this->errors;
    }
}
