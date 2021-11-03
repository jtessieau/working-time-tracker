<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\FormValidation\SigninFormValidation;

class AccountController extends AbstractController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function createAccount()
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new SigninFormValidation($_POST);
            $errorMessages = $validator->validate();

            // Populate new user
            if (empty($errorMessages)) {
                // Fill user object
                $this->userModel->setFirstName($_POST['firstName']);
                $this->userModel->setLastName($_POST['lastName']);
                $this->userModel->setEmail($_POST['email']);
                $this->userModel->setPassword($_POST['password']);

                // Check if user allready exist with his Email
                if ($this->userModel->findOneByEmail($this->userModel->getEmail())) {
                    $errorMessages['email'] = 'This email address is already used.';
                } else {
                    $this->userModel->createUser();
                    $this->redirect('/');
                }
            }
        }

        $this->render('user/signinForm', [
            'errorMessages' => $errorMessages
        ]);
    }
}
