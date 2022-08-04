<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use App\Application\User\ChangelogOperation;
use App\Application\User\UserChangelogService;
use App\Domain\Entity\User\User;
use App\Domain\Repository\UserChangelogRepositoryInterface;
use DateTime;
use PHPUnit\Framework\MockObject\MockObject;
use Tests\BaseTestCase;

/**
 * @group user
 * @group changelog
 * @group service
 */
class UserChangelogServiceTest extends BaseTestCase
{
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
        $operation = ChangelogOperation::add();
        /** @var UserChangelogRepositoryInterface|MockObject $userRepository */
        $userChangelogRepository = $this->createMock(UserChangelogRepositoryInterface::class);
        $changelogService = new UserChangelogService($userChangelogRepository);
        $userChangelogRepository->expects($this->once())
            ->method('add')
            ->with($user, $operation);
        $changelogService->add($user, $operation);
    }
}
