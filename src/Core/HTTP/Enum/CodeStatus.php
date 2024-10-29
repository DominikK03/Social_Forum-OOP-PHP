<?php

namespace app\Core\HTTP\Enum;

enum CodeStatus: int
{
    case OK = 200;
    case Created = 201;
    case Accepted = 202;

    case NotFound = 404;
    case Unauthorized = 401;
    case Forbidden = 403;
    case Unprocessable = 422;
    case InternalError = 500;


    case Conflict = 409;
}
