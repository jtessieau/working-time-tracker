<?php

namespace App\Controllers\Security;

use App\Models\UserModel as User;
use App\FormValidation\SigninFormValidation;
use App\Controllers\AbstractController;
use App\Http\Response;

class AccountController extends AbstractController
{
    protected User $user;
    protected Response $response;

    public function __construct()
    {
        $this->user = new User();
        $this->response = new Response();
    }

    public function createAccount()
    {
        // This  page should not be accessible to user alreay logged in.
        if (isset($_SESSION['user'])) {
            $res = new Response();

            $res->redirect('/');
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
                $this->user->setFirstName($_POST['firstName']);
                $this->user->setLastName($_POST['lastName']);
                $this->user->setEmail($_POST['email']);
                $this->user->setPassword($_POST['password']);

                $this->user->createUser();
                $this->response->redirect('/');
            }
        }

        $this->render('user/signinForm', [
            'errorMessages' => $errorMessages,
        ]);
    }
}
