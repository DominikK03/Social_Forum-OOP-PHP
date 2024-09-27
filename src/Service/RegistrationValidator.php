<?php

namespace app\Service;

use AllowDynamicProperties;
use app\mysqlClient;
use app\Util\StaticValidator;

#[AllowDynamicProperties] class RegistrationValidator
{
    public function __construct(mysqlClient $db)
    {
        $this->db = $db;
    }

    public function validate(string $username, string $email)
    {
        StaticValidator::assertUsernameExists($username, $this->db);
        StaticValidator::assertEmailExists($email, $this->db);

    }

}