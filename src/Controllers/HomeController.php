<?php

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('home');
    }
}
