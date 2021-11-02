<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends AbstractController
{
    public function logIn()
    {
        // Block access if an user is allready logged in
        if (isset($_SESSION['USER'])) {
            $this->redirect('/');
        }

        // Initialize error variable needed by the view
        $error = '';

        // If form data have been submit ...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form processing
            // Check if email is valid then retrieve user form db
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false) {
                $password = $_POST['password'];

                // Retrieve user by email
                $user = new UserModel();
                $user->setEmail($_POST['email']);
                $data = $user->findUserByEmail($user->getEmail());

                // if an user have been found in database
                if ($data !== false) {
                    // check password
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['USER'] = [
                            'firstName' => $data['first_name'],
                            'lastName' => $data['last_name'],
                            'email' => $data['email']
                        ];

                        $this->redirect('/');
                    } else {
//                         echo 'Password Error';
                    }
                } else {
//                     echo 'User not found';
                }
            }

            // If not found in db or email invalid, fill $error
            $error = 'Email or password incorrect';
        }

        $this->render('user/logInForm', [
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
            } else {
                $user->setEmail($_POST['email']);
            }

            if ($user->findOneByEmail($user->getEmail()) !== false) {
                $errors['email'] = 'Email address already in use.';
            }

            // Validate password
            if (!isset($_POST['password'])) {
                $errors['password'] = 'Password must be set.';
            } else if ($_POST['password'] !== $_POST['password2']) {
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
