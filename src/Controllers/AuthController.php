<?php

namespace App\Controllers;

use App\FormValidation\LoginFormValidation;
use App\Models\UserModel;

class AuthController extends AbstractController
{
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function Login()
    {

        /**
        * Login method need to receive 2 informations from POST :
        *     - email
        *     - password
        * Then find if an user exist in database with the given email.
        * If an user is found, compare password form POST with database result.
        */


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $validator = new LoginFormValidation($_POST);
            $errorMessages = $validator->validateLoginForm();


            if (empty($errorMessages)) {
                // Look for existing user in database
                $user = $this->userModel->findOneByEmail($_POST['email']);

                if ($user !== false && password_verify($_POST['password'], $user['password'])) {
                    // Set session with personnal informartion;
                    $_SESSION['user'] = [
                        'firstName' => ucfirst($user['first_name']),
                        'lastName' => strtoupper($user['last_name']),
                        'email' => strtolower($user['email'])
                    ];

                    $this->redirect('/');
                } else {
                    $errorMessages['connection'] = 'E-mail or password incorrect.';
                }
            }
        }

        $this->render('user/LoginForm',[
            'errorMessages' => $errorMessages
        ]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        $this->redirect('/');
    }
}
