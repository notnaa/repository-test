<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\Exception\AddUserException;
use App\Domain\Repository\Exception\GetUserException;
use App\Domain\Repository\Exception\UpdateUserException;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     *
     * @return UserInterface|null
     *
     * @throws GetUserException
     */
    public function get(int $id): ?UserInterface;

    /**
     * @param string $name
     *
     * @return UserInterface|null
     *
     * @throws GetUserException
     */
    public function getByName(string $name): ?UserInterface;

    /**
     * @param string $email
     *
     * @return UserInterface|null
     *
     * @throws GetUserException
     */
    public function getByEmail(string $email): ?UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws AddUserException
     */
    public function add(UserInterface $user): UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UpdateUserException
     */
    public function update(UserInterface $user): UserInterface;
}
