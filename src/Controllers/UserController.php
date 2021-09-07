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
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Todo: Validation

            // Retrieve user
            $user = new UserModel();
            $data = $user->findUserByEmail($email);

            if ($data !== false) {
                // check password
                if (password_verify($password, $data['password'])) {
                    echo 'Access granted';
                } else {
                    echo 'Password Error';
                }
            } else {
                echo 'User not found';
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
            // TODO: Validation
            if ($_POST['password'] !== $_POST['password2']) {
                $error['password'] = 'Passwords do not match.';
            }

            // Populate new user
            if (!isset($error)) {
                $newUser = [
                    'firstName' => $_POST['firstName'],
                    'lastName' => $_POST['lastName'],
                    'email' => $_POST['email'],
                    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT)
                ];

                $user->createUser($newUser);
            }
        }

        echo $this->render('signInForm');
    }

    public function deleteAccount()
    {
    }

}