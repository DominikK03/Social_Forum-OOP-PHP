<?php

namespace app\Service;

use AllowDynamicProperties;
use app\MysqlClient;
use app\Util\StaticValidator;

#[AllowDynamicProperties] class RegistrationValidator
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }

    public function validate(string $username, string $email)
    {
        StaticValidator::assertUsernameExists($username, $this->client);
        StaticValidator::assertEmailExists($email, $this->client);

    }

}