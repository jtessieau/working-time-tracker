<?php

namespace App\Controllers\Home;

use App\Controllers\Utils\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home', [
            "title" => "Wtt - Homepage",
            "hideNavabar" => true
        ]);
    }
}
