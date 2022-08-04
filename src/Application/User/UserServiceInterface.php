<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Application\User\Exception\UserValidateException;
use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\Exception\AddUserException;
use App\Domain\Repository\Exception\GetUserException;
use App\Domain\Repository\Exception\UpdateUserException;
use App\Domain\Repository\Exception\UserNotExistsException;

interface UserServiceInterface
{
    /**
     * @param int $id
     *
     * @return UserInterface
     *
     * @throws GetUserException
     * @throws UserNotExistsException
     */
    public function get(int $id): UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UserValidateException
     * @throws AddUserException
     */
    public function add(UserInterface $user): UserInterface;

    /**
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UserValidateException
     * @throws UpdateUserException
     * @throws UserNotExistsException
     * @throws GetUserException
     */
    public function update(UserInterface $user): UserInterface;
}
