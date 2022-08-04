<?php

declare(strict_types=1);

namespace App\Domain\Validator\User\Rules;

use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\UserRepositoryInterface;
use Respect\Validation\Rules\AbstractRule;

class UserNameUniqRule extends AbstractRule
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
        return 'UserNameUniqRule';
    }

    /**
     * @inheritDoc
     */
    public function validate($input): bool
    {
        /** @var UserInterface $input */
        $user = $this->repository->getByName($input->getName());
        return $user === null;
    }
}
