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
            // if (true) {
            //     echo 'no error';
            //     $user->createUser();
            //     $this->redirect('/');
            // }
        }

        $this->render('user/signinForm', [
            'errors' => $errors
        ]);
    }
}
