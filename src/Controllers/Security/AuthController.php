<?php

namespace App\Controllers\Security;

use App\FormValidation\LoginFormValidation;
use App\Models\UserModel as User;
use App\Controllers\AbstractController;
use App\Http\Request;
use App\Http\Response;

class AuthController extends AbstractController
{
    protected User $user;
    protected Response $reponse;
    protected Request $request;

    public function __construct()
    {
        $this->user = new User();
        $this->response = new Response();
        $this->request = new Request($_POST ?? []);
    }

    public function Login()
    {
        /**
         * Login method need to receive 2 informations from POST :
         *   - email
         *   - password
         * Then find if an user exist in database with the given email.
         * If an user is found, compare password form POST with database result.
         */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new LoginFormValidation($_POST);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                // Look for existing user in database
                $user = $this->user->findOneByEmail(
                    $this->request->get('email')
                );

                // If user is found & passwords match
                if (
                    $user !== false &&
                    password_verify(
                        $this->request->get('password'),
                        $user['password']
                    )
                ) {
                    // Then set session with personnal informations & redirect to homepage;
                    $_SESSION['user'] = [
                        'firstName' => ucfirst($user['first_name']),
                        'lastName' => strtoupper($user['last_name']),
                        'email' => strtolower($user['email']),
                    ];
                    $this->response->redirect('/');
                } else {
                    $errorMessages['connection'] =
                        'E-mail or password incorrect.';
                }
            }
        }

        $this->render('user/LoginForm', [
            'errorMessages' => $errorMessages,
        ]);
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        $this->response->redirect('/');
    }
}
