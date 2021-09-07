<?php

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function index()
    {
        echo $this->render('home');
    }
}