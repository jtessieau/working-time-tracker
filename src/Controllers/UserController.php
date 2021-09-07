<?php

namespace App\Controllers;

use App\Models\UserModel;

// use Symfony\Component\Validator\Constraints as Assert;
// use Symfony\Component\Validator\Validation;

class UserController extends AbstractController
{
    public function logIn()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form processing
            echo 'form processing';
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if ($email !== false) {
                // Retrieve user
                $user = new UserModel();
                $data = $user->findUserByEmail($email);

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
                        echo 'Password Error';
                    }
                } else {
                    echo 'User not found';
                }
            }
        }

        echo $this->render('logInForm');
    }

    public function logOut()
    {
        session_unset();
        session_destroy();

        $this->redirect('/');
    }

    public function signIn()
    {
        $user = new UserModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validations
            // Validate first name
            if (!isset($_POST['firstName'])) {
                $error['firstName'] = 'First name not set';
            } else {
                $firstName = trim($_POST['firstName']);
                $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
                $firstName = ucfirst($firstName);
            }

            // Validate last name
            if (!isset($_POST['lastName'])) {
                $error['lastName'] = 'Last name not set';
            } else {
                $lastName = trim($_POST['lastName']);
                $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
                $lastName = strtoupper($lastName);
            }

            // Validate email
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
                $error['email'] = 'Email is not a valid E-mail';
            } else {
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            }

            // Validate password
            if ($_POST['password'] !== $_POST['password2']) {
                $error['password'] = 'Passwords do not match.';
            } else {
                $password = $_POST['password'];
            }

            // Populate new user
            if (!isset($error)) {
                $newUser = [
                    'firstName' => $firstName,
                    'lastName' => $lastName,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_BCRYPT)
                ];

                $user->createUser($newUser);
                $this->redirect('/');
            }
            else {
                echo 'Error';
            }
        }

        echo $this->render('signInForm');
    }

    public function deleteAccount()
    {
    }

}