<?php

declare(strict_types=1);

namespace App\Application\User;

use App\Application\User\Exception\UserValidateException;
use App\Domain\Entity\User\UserInterface;
use App\Domain\Repository\Exception\UserNotExistsException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Validator\User\UserValidator;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $repository;

    /**
     * @var UserValidator
     */
    protected UserValidator $validator;

    /**
     * @var UserChangelogServiceInterface
     */
    protected UserChangelogServiceInterface $changelogService;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param UserValidator $userValidator
     * @param UserChangelogServiceInterface $changelogService
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserValidator $userValidator,
        UserChangelogServiceInterface $changelogService
    ) {
        $this->repository = $userRepository;
        $this->validator = $userValidator;
        $this->changelogService = $changelogService;
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): UserInterface
    {
        $result = $this->repository->get($id);
        if (null === $result) {
            throw new UserNotExistsException();
        }
        return $result;
    }

    /**
     * @inheritDoc
     */
    public function add(UserInterface $user): UserInterface
    {
        $validateErrors = $this->validator->validate($user);
        if ($validateErrors !== []) {
            throw new UserValidateException(json_encode($validateErrors));
        }

        $result = $this->repository->add($user);
        $this->changelogService->add($user, ChangelogOperation::add());

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function update(UserInterface $user): UserInterface
    {
        $validateErrors = $this->validator->validate($user);
        if ($validateErrors !== []) {
            throw new UserValidateException(json_encode($validateErrors));
        }

        $this->get($user->getId());
        $result = $this->repository->update($user);
        $this->changelogService->add($user, ChangelogOperation::update());

        return $result;
    }
}
