<?php

declare(strict_types=1);

namespace Tests\Unit\User\Rules;

use App\Domain\Entity\User\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Validator\User\Rules\UserNameUniqRule;
use DateTime;
use Tests\BaseTestCase;

/**
 * @group user
 * @group validator
 */
class UserNameUniqRuleTest extends BaseTestCase
{
    public function testValidateSuccess()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByName')
            ->with($user->getName())
            ->willReturn(null);
        $rule = new UserNameUniqRule($repository);
        $result = $rule->validate($user);
        $this->assertTrue($result);
    }

    public function testValidateError()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
            null,
            null,
            1,
        );
        $repository = $this->createMock(UserRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('getByName')
            ->with($user->getName())
            ->willReturn($user);
        $rule = new UserNameUniqRule($repository);
        $result = $rule->validate($user);
        $this->assertFalse($result);
    }
}
