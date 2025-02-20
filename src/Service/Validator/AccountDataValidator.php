<?php

namespace app\Service\Validator;
use app\Exception\PasswordDoesntMatchException;

class AccountDataValidator
{
    public function assertPasswordConfirmation(string $enteredPassword, string $userPassword)
    {
        if(!password_verify($enteredPassword, $userPassword))
        {
            throw new PasswordDoesntMatchException();
        }
    }
}