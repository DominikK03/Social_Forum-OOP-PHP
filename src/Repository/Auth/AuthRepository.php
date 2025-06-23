<?php

namespace app\Repository\Auth;

use AllowDynamicProperties;
use app\Exception\KeyAlreadyExistException;
use app\Exception\KeyDoesntExistException;
use app\PDO\MysqlClientInterface;
use app\Enum\Role;
use app\Exception\UsernameAlreadyExistsException;
use app\Model\User;
use app\Util\StaticValidator;
use DateTime;
use Ramsey\Uuid\Uuid;

#[AllowDynamicProperties]
class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(MysqlClientInterface $client)
    {
        $this->client = $client;
    }
    public function registerUser(User $user): void
    {
        $insertBuilder = $this->client
            ->createQueryBuilder()
            ->insert('user',
                [
                    'userID' => $user->getUserId(),
                    'userName' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'passwordHash' => $user->getPasswordHash(),
                    'role' => $user->getRole()->name,
                    'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
                ]);
        $this->client->persist($insertBuilder->getInsertQuery());
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
            ->where('userName', '=', $username);
        $userData = $this->client->persist($builder->getSelectQuery())->getOneOrNullResult();
        if ($userData) {
            return new User(
                Uuid::fromString($userData['userID']),
                $userData['userName'],
                $userData['email'],
                $userData['passwordHash'],
                new DateTime($userData['createdAt']),
                Role::from($userData['role'])
            );
        }
        return null;
    }
    /**
     * @throws KeyDoesntExistException
     */
    public function verifyUsernameExistence(string $username): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(['userName'])
            ->from('user')
            ->where('userName', '=', $username);
        StaticValidator::assertKeyExist(
            $username,
            $this->client->persist($builder->getSelectQuery())->getOneOrNullResult(),
        );
    }

    /**
     * @throws KeyAlreadyExistException
     */
    public function verifyEmailExistence(string $email): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(['email'])
            ->from('user')
            ->where('email', '=', $email);
        StaticValidator::assertKeyDoesNotExist(
            $email,
            $this->client->persist($builder->getSelectQuery())->getOneOrNullResult(),
        );
    }
    public function verifyPasswordCorrectness(string $username, string $password): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(['userName', 'passwordHash'])
            ->from('user')
            ->where('userName', '=', $username);
        password_verify(
            $password,
            $this->client->persist($builder->getSelectQuery())->getOneOrNullResult()['passwordHash']
        );
    }

    /**
     * @throws KeyAlreadyExistException
     */
    public function assureUsernameDoesntExist(string $username): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(['userName'])
            ->from('user')
            ->where('userName', '=', $username);
        StaticValidator::assertKeyDoesNotExist(
            $username,
            $this->client->persist($builder->getSelectQuery())->getOneOrNullResult(),
        );


    }
}