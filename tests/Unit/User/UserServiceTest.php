<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use App\Application\User\ChangelogOperation;
use App\Application\User\Exception\UserValidateException;
use App\Application\User\UserChangelogServiceInterface;
use App\Application\User\UserService;
use App\Domain\Entity\User\User;
use App\Domain\Repository\Exception\AddUserException;
use App\Domain\Repository\Exception\GetUserException;
use App\Domain\Repository\Exception\UpdateUserException;
use App\Domain\Repository\Exception\UserNotExistsException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Validator\User\UserValidator;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\BaseTestCase;

/**
 * @group user
 * @group service
 */
class UserServiceTest extends BaseTestCase
{
    /**
     * @throws GetUserException
     * @throws UserNotExistsException
     */
    public function testGet()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        /** @var UserRepositoryInterface|MockObject $userRepository */
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->once())
            ->method('get')
            ->with($user->getId())
            ->willReturn($user);
        /** @var UserValidatorTest|MockObject $userValidator */
        $userValidator = $this->createMock(UserValidator::class);
        $userValidator->expects($this->never())->method('validate');
        /** @var UserChangelogServiceInterface|MockObject $changelogService */
        $changelogService = $this->createMock(UserChangelogServiceInterface::class);
        $changelogService->expects($this->never())->method('add');
        $service = new UserService($userRepository, $userValidator, $changelogService);
        $result = $service->get($user->getId());
        $this->assertEquals($user->getId(), $result->getId());
    }

    /**
     * @throws UserValidateException
     * @throws AddUserException
     */
    public function testAdd()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        /** @var UserRepositoryInterface|MockObject $userRepository */
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->once())
            ->method('add')
            ->with($user)
            ->willReturn($user);
        /** @var UserValidatorTest|MockObject $userValidator */
        $userValidator = $this->createMock(UserValidator::class);
        $userValidator->expects($this->once())
            ->method('validate')
            ->with($user)
            ->willReturn([]);
        /** @var UserChangelogServiceInterface|MockObject $changelogService */
        $changelogService = $this->createMock(UserChangelogServiceInterface::class);
        $changelogService->expects($this->once())
            ->method('add')
            ->with($user, ChangelogOperation::add());
        $service = new UserService($userRepository, $userValidator, $changelogService);
        $service->add($user);
    }

    /**
     * @throws AddUserException
     * @throws GetUserException
     * @throws UpdateUserException
     * @throws UserNotExistsException
     * @throws UserValidateException
     */
    public function testUpdate()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $updatedUser = new User(
            'name_new',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        /** @var UserRepositoryInterface|MockObject $userRepository */
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->once())
            ->method('add')
            ->with($user)
            ->willReturn($user);
        $userRepository->expects($this->once())
            ->method('get')
            ->with($updatedUser->getId())
            ->willReturn($user);
        $userRepository->expects($this->once())
            ->method('update')
            ->with($updatedUser)
            ->willReturn($updatedUser);
        /** @var UserValidatorTest|MockObject $userValidator */
        $userValidator = $this->createMock(UserValidator::class);
        $userValidator->expects($this->atLeast(2))
            ->method('validate')
            ->withConsecutive([$user], [$updatedUser])
            ->willReturnOnConsecutiveCalls([], []);
        /** @var UserChangelogServiceInterface|MockObject $changelogService */
        $changelogService = $this->createMock(UserChangelogServiceInterface::class);
        $changelogService->expects($this->atLeast(2))
            ->method('add')
            ->withConsecutive([$user, ChangelogOperation::add()], [$updatedUser, ChangelogOperation::update()]);
        $service = new UserService($userRepository, $userValidator, $changelogService);
        $service->add($user);
        $result = $service->update($updatedUser);
        $this->assertEquals($updatedUser->getId(), $result->getId());
        $this->assertEquals($updatedUser->getName(), $result->getName());
    }
}
