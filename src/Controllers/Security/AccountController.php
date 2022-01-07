<?php

namespace App\Controllers\Security;

use App\Models\UserModel;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\FormValidation\UserManagerForm\SigninFormValidation;
use App\FormValidation\UserManagerForm\ModifyEmailFormValidation;

class AccountController extends AbstractController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function create()
    {
        // This  page should not be accessible to user already logged in.
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
                $this->userModel->setFirstName($req->request->get('firstName'));
                $this->userModel->setLastName($req->request->get('lastName'));
                $this->userModel->setEmail($req->request->get('email'));
                $this->userModel->setPassword($req->request->get('password'));

                $this->userModel->createUser();
                $res = new RedirectResponse('/');
                $res->send();
            }
        }

        return $this->render('user/signinForm', [
            'errorMessages' => $errorMessages ?? [],
        ]);
    }

    public function delete()
    {
        $userData = $this->userModel->findOneByEmail($_SESSION['user']['email']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = Request::createFromGlobals();
            $confirmation = $req->request->get('confirmation');

            if ($confirmation === "Delete") {
                $delete = $this->userModel->delete($userData['id']);
                if ($delete) {
                    session_unset();
                    session_destroy();
                    $res = new RedirectResponse("/");
                } else {
                    $res = new Response('Whoops, something went wrong ...', 500);
                }
            } else {
                $res = new RedirectResponse('/user/manage');
            }
            $res->send();
        }

        return $this->render('user/deleteForm');
    }


    public function manage()
    {
        $userData = $this->userModel->findOneByEmail($_SESSION['user']['email']);

        $this->render('user/userManager', [
            'userData' => $userData
        ]);
    }

    public function modifyEmail()
    {
        $userData = $this->userModel->findOneByEmail($_SESSION['user']['email']);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $formData['email'] = $userData['email'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = Request::createFromGlobals();
            $formData = [
                'email' => strtolower($req->request->get('email')),
                'emailConfirmation' => strtolower($req->request->get('emailConfirmation'))
            ];

            $validator = new ModifyEmailFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $this->userModel->setEmail($formData['email']);
                $this->userModel->setId($userData['id']);
                if ($this->userModel->getEmail() !== '') {
                    $this->userModel->persistEmail();
                    $_SESSION['user']['email'] = $this->userModel->getEmail();
                    $res = new RedirectResponse('/user/manage');
                    $res->send();
                } else {
                    $errorMessages['email'] = "Invalid email address.";
                }
            }
        }

        $this->render('/user/emailForm', [
            'email' => $formData['email'],
            'errorMessages' => $errorMessages ?? []
        ]);
    }
}
