<?php

namespace app\Controller;

use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\ResponseInterface;

class AccountController
{
    public function __construct()
    {
    }

    #[Route('/account', 'GET')]

    public function accountView(Request $request) : ResponseInterface
    {

    }

}