<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\Exception\AddUserException;
use App\Domain\Repository\Exception\GetUserException;
use App\Domain\Repository\Exception\UpdateUserException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Serializer\UserSerializerInterface;
use Spiral\Database\DatabaseInterface;
use Spiral\Database\DatabaseProviderInterface;
use Spiral\Database\Query\SelectQuery;

class MySqlUserRepository implements UserRepositoryInterface
{
    private const TABLE_NAME = 'users';
    private const FIELDS = ['id', 'name', 'email', 'created', 'deleted', 'notes'];

    /**
     * @var DatabaseInterface
     */
    private DatabaseInterface $db;

    /**
     * @var UserSerializerInterface
     */
    private UserSerializerInterface $serializer;

    /**
     * @param DatabaseProviderInterface $provider
     * @param UserSerializerInterface $userSerializer
     */
    public function __construct(DatabaseProviderInterface $provider, UserSerializerInterface $userSerializer)
    {
        $this->db = $provider->database();
        $this->serializer = $userSerializer;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): ?UserInterface
    {
        $query = $this->db
            ->select(self::FIELDS)
            ->from(self::TABLE_NAME)
            ->where(['id' => $id])
            ->limit(1);
        return $this->getUser($query);
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name): ?UserInterface
    {
        $query = $this->db
            ->select(self::FIELDS)
            ->from(self::TABLE_NAME)
            ->where(['name' => trim($name)])
            ->limit(1);
        return $this->getUser($query);
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email): ?UserInterface
    {
        $query = $this->db
            ->select(self::FIELDS)
            ->from(self::TABLE_NAME)
            ->where(['email' => trim($email)])
            ->limit(1);
        return $this->getUser($query);
    }

    /**
     * @inheritDoc
     */
    public function add(UserInterface $user): UserInterface
    {
        $data = $this->serializer->serialize($user);
        $query = $this->db
            ->insert(self::TABLE_NAME)
            ->columns(array_keys($data))
            ->values($data);

        try {
            $id = (int)$query->run();
            if ($id === 0) {
                throw new AddUserException();
            }
            $user->setId($id);
        } catch (\Throwable $exception) {
            throw new AddUserException($exception->getMessage());
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function update(UserInterface $user): UserInterface
    {
        $data = $this->serializer->serialize($user);
        $query = $this->db->update(self::TABLE_NAME);

        foreach ($data as $key => $value) {
            $query->set($key, $value);
        }
        try {
            $query->where(['id' => $user->getId()])->run();
        } catch (\Throwable $exception) {
            throw new UpdateUserException($exception->getMessage());
        }

        return $user;
    }

    /**
     * @param SelectQuery $query
     *
     * @return UserInterface|null
     *
     * @throws GetUserException
     */
    private function getUser(SelectQuery $query): ?UserInterface
    {
        try {
            $records = $query->fetchAll();
        } catch (\Throwable $exception) {
            throw new GetUserException($exception->getMessage());
        }

        $user = null;
        foreach ($records as $record) {
            $user = $record;
        }

        $result = null;
        if (null !== $user) {
            $result = $this->serializer->unserialize($user);
        }

        return $result;
    }
}
