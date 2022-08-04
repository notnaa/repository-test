<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Application\User\ChangelogOperation;
use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\UserChangelogRepositoryInterface;

class InMemoryUserChangelogRepository implements UserChangelogRepositoryInterface
{
    /**
     * @var array
     */
    private array $storage = [];

    /**
     * @inheritDoc
     */
    public function add(UserInterface $user, ChangelogOperation $operation): void
    {
        $this->storage[] = [
            'operation' => $operation,
            'user' => $user,
            'datetime' => new \DateTime(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->storage;
    }
}
