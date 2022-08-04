<?php

declare(strict_types=1);

namespace Tests\Unit\User;

use App\Domain\Entity\User\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Validator\User\UserValidator;
use DateTime;
use Tests\BaseTestCase;

class UserValidatorTest extends BaseTestCase
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
        $repository->expects($this->once())
            ->method('getByEmail')
            ->with($user->getEmail())
            ->willReturn(null);
        $validator = new UserValidator($repository);
        $result = $validator->validate($user);
        $this->assertEquals([], $result);
    }
}
