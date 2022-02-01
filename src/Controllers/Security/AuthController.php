<?php

namespace App\Controllers\Security;

use App\Models\UserModel;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\FormValidation\UserManagerForm\LoginFormValidation;

class AuthController extends AbstractController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
            $validator = new LoginFormValidation($req->request->all());
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                // Look for existing user in database
                $user = $this->userModel->findOneByEmail(
                    $req->request->get('email')
                );

                // If user is found & passwords match
                if (
                    $user !== null &&
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

        return $this->render('user/LoginForm', [
            'errorMessages' => $errorMessages ?? [],
            'title' => 'WTT - Login'
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
