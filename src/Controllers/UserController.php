<?php

namespace App\Controllers;

use App\Models\UserModel;

// use Symfony\Component\Validator\Constraints as Assert;
// use Symfony\Component\Validator\Validation;

class UserController extends AbstractController
{
    public function logIn()
    {
        if (isset($_SESSION['USER'])) {
            $this->redirect('/');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form processing
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false) {
                $password = $_POST['password'];

                // Retrieve user
                $user = new UserModel();
                $user->setEmail($_POST['email']);
                $data = $user->findUserByEmail($user->getEmail());

                if ($data !== false) {
                    // check password
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['USER'] = [
                            'firstName' => $data['firstName'],
                            'lastName' => $data['lastName'],
                            'email' => $data['email']
                        ];

                        $this->redirect('/');
                    } else {
                        // echo 'Password Error';
                    }
                } else {
                    // echo 'User not found';
                }
            }

            $error = 'Email or password incorrect';
        }

        $this->render('user/logInForm',[
            'error' => $error
        ]);
    }

    public function logOut(): void
    {
        session_unset();
        session_destroy();

        $this->redirect('/');
    }

    public function signIn()
    {
        if (isset($_SESSION['USER'])) {
            $this->redirect('/');
        }

        $user = new UserModel();

        // Init errors array for the view.
        $errors = [
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'password' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validations
            // Validate first name
            if (!isset($_POST['firstName'])) {
                $errors['firstName'] = 'First name must be set.';
            } else {
                $user->setFirstName($_POST['firstName']);
            }

            // Validate last name
            if (!isset($_POST['lastName'])) {
                $errors['lastName'] = 'Last name must be set.';
            } else {
                $user->setLastName($_POST['lastName']);
            }

            // Validate email
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'Email is not a valid E-mail.';
            }
            else {
                $user->setEmail($_POST['email']);
            }

            if ($user->findUserByEmail($user->getEmail()) !== false) {
                $errors['email'] = 'Email address already in use.';
            }

            // Validate password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'Password must be set.';
            }
            else if ($_POST['password'] !== $_POST['password2']) {
                $errors['password'] = 'Passwords do not match.';
            } else {
                $user->setPassword($_POST['password']);
            }

            // Populate new user
            if (!$this->checkError($errors)) {
                echo 'no error';
                $user->createUser();
                $this->redirect('/');
            }
        }

        $this->render('user/signInForm', [
            'errors' => $errors
        ]);
    }

    public function deleteAccount()
    {
    }

}