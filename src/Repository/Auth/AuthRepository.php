<?php

namespace app\Repository\Auth;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\Exception\UsernameAlreadyExistsException;
use app\Model\User;
use app\MysqlClientInterface;
use app\Util\StaticValidator;
use DateTime;
use Ramsey\Uuid\Uuid;

#[AllowDynamicProperties] class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(MysqlClientInterface $client)
    {
        $this->client = $client;
    }

    public function registerUser(User $user)
    {
        $insertBuilder = $this->client
            ->createQueryBuilder()
            ->insert('user',
                [
                    'user_id' => $user->getUserId(),
                    'user_name' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'password_hash' => $user->getPasswordHash(),
                    'role' => $user->getRole()->name,
                    'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')
                ]);
        $this->client->pushWithoutResults($insertBuilder->getInsertQuery());

    }

    /**
     * @throws \Exception
     */
    public function findByUsername(string $username): ?User
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select()
            ->from('user')
            ->where('user_name', '=', $username);
        $userData = $this->client->getOneOrNullResult($builder->getSelectQuery());
        if ($userData) {
            return new User(
                Uuid::fromString($userData['user_id']),
                $userData['user_name'],
                $userData['email'],
                $userData['password_hash'],
                new DateTime($userData['created_at']),
                Role::fromName($userData['role'])
            );
        }
        return null;
    }

    /**
     * @throws UsernameAlreadyExistsException
     */
    public function verifyUsernameExistence(string $username): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select('user_name')
            ->from('user')
            ->where('user_name', '=', $username);
        StaticValidator::assertUsernameExists($username, $this->client->getOneOrNullResult($builder->getSelectQuery()));

    }

    public function verifyEmailExistence(string $email): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select('email')
            ->from('user')
            ->where('email', '=', $email);
        StaticValidator::assertEmailExists($email, $this->client->getOneOrNullResult($builder->getSelectQuery()));
    }

    /**
     * @throws PasswordDoesntMatchException
     * @throws UserDoesntExistException
     * @throws \Exception
     */
    public function verifyLoginRequest(string $username, string $password): void
    {
        StaticValidator::verifyLoginRequest(
            $this->findByUsername($username),
            $username,
            $password,
            $this->findByUsername($username)?->getPasswordHash());
    }

}