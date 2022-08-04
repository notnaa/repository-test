<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\User\Rules;

use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Respect\Validation\Rules\AbstractRule;

class UserEmailUniqRule extends AbstractRule
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return 'UserEmailUniqRule';
    }

    /**
     * @inheritDoc
     */
    public function validate($input): bool
    {
        /** @var UserInterface $input */
        $user = $this->repository->getByEmail($input->getEmail());
        return $user === null;
    }
}
