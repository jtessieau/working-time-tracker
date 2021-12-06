<?php

namespace App\Controllers\Security;

use App\Models\UserModel as User;
use App\FormValidation\SigninFormValidation;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends AbstractController
{
    protected User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function createAccount()
    {
        // This  page should not be accessible to user alreay logged in.
        if (isset($_SESSION['user'])) {
            $res = new RedirectResponse('/');
            $res->send();
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
            $req = Request::createFromGlobals();
            $validator = new SigninFormValidation($req->request->all());
            $errorMessages = $validator->validate();

            // If no error, then populate new user object with data.
            // Object methods will handle normalisation.
            if (empty($errorMessages)) {
                $this->user->setFirstName($req->request->get('firstName'));
                $this->user->setLastName($req->request->get('lastName'));
                $this->user->setEmail($req->request->get('email'));
                $this->user->setPassword($req->request->get('password'));

                $this->user->createUser();
                $res = new RedirectResponse('/');
                $res->send();
            }
        }

        $this->render('user/signinForm', [
            'errorMessages' => $errorMessages ?? [],
        ]);
    }
}
