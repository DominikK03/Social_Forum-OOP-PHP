<?php

namespace app\PDO;
interface ConnectionConfig
{
    public function getDsn(): string;
    public function getUser(): string;
    public function getPassword(): string;
}