<?php

namespace app\Controller;

use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\ResponseInterface;

class RegisterController
{
    public function __construct()
    {
    }
    #[Route('/register', 'GET')]

    public function registerView(Request $request) : ResponseInterface
    {

    }

}