<?php

namespace App\Controllers\Home;

use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends AbstractController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            $res = new RedirectResponse('/job/list');
            $res->send();
        }

        return $this->render('home', [
            "title" => "Wtt - Homepage",
            "hideNavbar" => true
        ]);
    }
}
