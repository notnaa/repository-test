<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Entity\User\UserInterface;

interface UserChangelogServiceInterface
{
    /**
     * @param UserInterface $user
     * @param ChangelogOperation $operation
     */
    public function add(UserInterface $user, ChangelogOperation $operation): void;

    /**
     * @return array
     */
    public function getAll(): array;
}
