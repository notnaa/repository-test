<?php

declare(strict_types=1);

namespace Tests\Functional\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\Exception\AddUserException;
use App\Domain\Repository\Exception\GetUserException;
use App\Domain\Repository\Exception\UpdateUserException;
use App\Infrastructure\Serializer\UserSerializer;
use App\Infrastructure\User\MySqlUserRepository;
use DateTime;
use Tests\Functional\TestHelper;
use Tests\Functional\BaseDbTestCase;

/**
 * @group user
 * @group repository
 */
class MySqlUserRepositoryTest extends BaseDbTestCase
{
    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        TestHelper::truncateUserTable($this->db);
    }

    /**
     * @throws AddUserException
     * @throws GetUserException
     */
    public function testAdd(): void
    {
        $repository = $this->getMySqlUserRepository();
        $expected = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
        );
        $user = $repository->add($expected);
        $result = $repository->get($user->getId());
        $this->assertUser($result, $expected);
    }

    /**
     * @throws AddUserException
     * @throws GetUserException
     * @throws UpdateUserException
     */
    public function testUpdate(): void
    {
        $repository = $this->getMySqlUserRepository();
        $expected = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
        );
        $user = $repository->add($expected);
        $result = $repository->get($user->getId());
        $this->assertUser($result, $expected);

        $user->setName('name_new');
        $repository->update($user);
        $result = $repository->get($user->getId());
        $this->assertUser($result, $user);
    }

    /**
     * @throws GetUserException
     */
    public function testGetNotExists(): void
    {
        $repository = $this->getMySqlUserRepository();
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $result = $repository->get($user->getId());
        $this->assertNull($result);
    }

    /**
     * @throws AddUserException
     * @throws GetUserException
     */
    public function testGetByName(): void
    {
        $repository = $this->getMySqlUserRepository();
        $expected = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
        );
        $user = $repository->add($expected);
        $result = $repository->getByName($user->getName());
        $this->assertUser($result, $expected);
    }

    /**
     * @throws AddUserException
     * @throws GetUserException
     */
    public function testGetByEmail(): void
    {
        $repository = $this->getMySqlUserRepository();
        $expected = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
        );
        $user = $repository->add($expected);
        $result = $repository->getByEmail($user->getEmail());
        $this->assertUser($result, $expected);
    }

    /**
     * @param UserInterface $expected
     * @param UserInterface $actual
     */
    private function assertUser(UserInterface $expected, UserInterface $actual): void
    {
        $this->assertEquals($actual->getId(), $expected->getId());
        $this->assertEquals($actual->getName(), $expected->getName());
        $this->assertEquals($actual->getEmail(), $expected->getEmail());
        $this->assertEquals($actual->getCreatedAt()->getTimestamp(), $expected->getCreatedAt()->getTimestamp());
        $this->assertEquals(
            null !== $actual->getDeletedAt() ? $actual->getDeletedAt()->getTimestamp() : null,
            null !== $expected->getDeletedAt() ? $expected->getDeletedAt()->getTimestamp() : null,
        );
        $this->assertEquals($actual->getNotes(), $expected->getNotes());
    }

    /**
     * @return MySqlUserRepository
     */
    private function getMySqlUserRepository(): MySqlUserRepository
    {
        $serializer = new UserSerializer();
        return new MySqlUserRepository($this->db, $serializer);
    }
}
