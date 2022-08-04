<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Application\User\ChangelogOperation;
use App\Domain\Entity\User\UserInterface;

interface UserChangelogRepositoryInterface
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
