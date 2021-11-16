<?php

namespace App\Controllers\Checkin;

use App\Controllers\AbstractController;
use App\Http\Request;

class CreateCheckinController extends AbstractController
{
    public function create()
    {
        // This  page should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            $this->response->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD' === 'POST']) {
            $req = new Request($_POST);
        }
    }
}
