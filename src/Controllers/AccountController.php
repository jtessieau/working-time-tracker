<?php

namespace App\Controllers;

use App\FormValidation\SigninFormValidation;

class AccountController extends AbstractController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function createAccount()
    {

        // This  page should not be accessible to user alreay logged in.
        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }

        /**
        * Signin method need to receive 5 informations from POST :
        *   - firstName
        *   - lastName
        *   - email
        *   - password
        *   - password2
        * Abort creation if an user already exist in database with the given email.
        * Else create the user after a successful validation.
        */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new SigninFormValidation($_POST);
            $errorMessages = $validator->validate();

            // If no error, then populate new user object with data.
            // Object methods will handle normalisation.
            if (empty($errorMessages)) {
                $this->userModel->setFirstName($_POST['firstName']);
                $this->userModel->setLastName($_POST['lastName']);
                $this->userModel->setEmail($_POST['email']);
                $this->userModel->setPassword($_POST['password']);

                $this->userModel->createUser();
                $this->redirect('/');
            }
        }

        $this->render('user/signinForm', [
            'errorMessages' => $errorMessages
        ]);
    }
}
