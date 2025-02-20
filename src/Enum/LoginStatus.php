<?php

namespace app\Enum;
enum LoginStatus: string
{
    case notLoggedIn = 'not-logged-in';
    case logOut = 'logout';
}
