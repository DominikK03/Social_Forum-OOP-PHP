<?php

namespace app\Util;
class SessionManager
{
    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function createSession(string $sessionName, array $sessionParams): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION[$sessionName] = $sessionParams;
    }
    public function alterSession(string $sessionName, string $sessionParam, mixed $newSessionParamValue): void
    {
        $_SESSION[$sessionName][$sessionParam] = $newSessionParamValue;
    }
    public function unsetSession(string $sessionName): void
    {
        unset($_SESSION[$sessionName]);
    }
    public function issetSession(string $sessionName): bool
    {
        return isset($_SESSION[$sessionName]);
    }
}