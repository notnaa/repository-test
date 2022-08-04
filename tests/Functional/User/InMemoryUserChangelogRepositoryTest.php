<?php

declare(strict_types=1);

namespace Tests\Functional\User;

use App\Application\User\ChangelogOperation;
use App\Domain\Entity\User\User;
use App\Infrastructure\User\InMemoryUserChangelogRepository;
use DateTime;
use Tests\BaseTestCase;

class InMemoryUserChangelogRepositoryTest extends BaseTestCase
{
    public function testAdd()
    {
        $user = new User(
            'name',
            'name@gmail.com',
            new DateTime(),
        );
        $operation = ChangelogOperation::add();
        $repository = new InMemoryUserChangelogRepository();
        $repository->add($user, $operation);
        $changelog = $repository->getAll()[0];
        $this->assertEquals($user, $changelog['user']);
        $this->assertEquals($operation, $changelog['operation']);
        $this->assertTrue($changelog['datetime']->getTimestamp() <= time());
    }
}
