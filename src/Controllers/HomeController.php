<?php

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function index()
    {
        $this->render('home');
    }
}
