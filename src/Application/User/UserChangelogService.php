<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\UserChangelogRepositoryInterface;

class UserChangelogService implements UserChangelogServiceInterface
{
    /**
     * @var UserChangelogRepositoryInterface
     */
    private UserChangelogRepositoryInterface $repository;

    /**
     * @param UserChangelogRepositoryInterface $repository
     */
    public function __construct(UserChangelogRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function add(UserInterface $user, ChangelogOperation $operation): void
    {
        $this->repository->add($user, $operation);
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->repository->getAll();
    }
}
