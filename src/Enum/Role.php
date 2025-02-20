<?php

namespace app\Enum;
enum Role: string
{
    case user = 'user';
    case admin = 'admin';
    case master = 'master';
}
