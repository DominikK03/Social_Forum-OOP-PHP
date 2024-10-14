<?php

namespace app\Model;

use app\Enum\Role;
use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class User
{

    public function __construct(private UuidInterface     $userId,
                                private string            $userName,
                                private string            $email,
                                private string            $passwordHash,
                                private DateTimeInterface $createdAt,
                                private Role              $role = Role::user)
    {
    }


    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * @param Role $role
     */
    public function setRole(Role $role): void
    {
        $this->role = $role;
    }


    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}