<?php

declare(strict_types=1);

namespace Tests\Unit\User\Rules;

use App\Domain\Entity\User\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Validator\User\Rules\UserEmailBlackDomainsRule;
use App\Domain\Validator\User\Rules\UserEmailUniqRule;
use DateTime;
use Tests\BaseTestCase;

/**
 * @group user
 * @group validator
 */
class UserEmailUniqRuleTest extends BaseTestCase
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
            ->method('getByEmail')
            ->with($user->getEmail())
            ->willReturn(null);
        $rule = new UserEmailUniqRule($repository);
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
            ->method('getByEmail')
            ->with($user->getEmail())
            ->willReturn($user);
        $rule = new UserEmailUniqRule($repository);
        $result = $rule->validate($user);
        $this->assertFalse($result);
    }
}
