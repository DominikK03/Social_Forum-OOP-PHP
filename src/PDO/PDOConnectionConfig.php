<?php

namespace app\PDO;
class PDOConnectionConfig implements ConnectionConfig
{
    public function __construct(
        private string $driver,
        private string $host,
        private string $database,
        private string $user,
        private string $password
    )
    {}
    public function getDsn(): string
    {
        return "{$this->driver}:host={$this->host};dbname={$this->database}";
    }
    public function getUser(): string
    {
        return $this->user;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}
