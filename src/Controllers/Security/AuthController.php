<?php

namespace App\Controllers\Security;

use App\Models\UserModel as User;
use App\FormValidation\LoginFormValidation;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController
{
    protected User $user;

    public function __construct()
    {
        $this->user = new User();
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
            $req = Request::createFromGlobals();
            $validator = new LoginFormValidation($_POST);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                // Look for existing user in database
                $user = $this->user->findOneByEmail(
                    $req->request->get('email')
                );

                // If user is found & passwords match
                if (
                    $user !== false &&
                    password_verify(
                        $req->request->get('password'),
                        $user['password']
                    )
                ) {
                    // Then set session with personnal informations & redirect to homepage;
                    $_SESSION['user'] = [
                        'firstName' => ucfirst($user['first_name']),
                        'lastName' => strtoupper($user['last_name']),
                        'email' => strtolower($user['email']),
                    ];
                    $response = new RedirectResponse('/');
                    $response->send();
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

        $response = new RedirectResponse('/');
        $response->send();
    }
}
