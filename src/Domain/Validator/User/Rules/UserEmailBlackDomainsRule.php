<?php

declare(strict_types=1);

namespace App\Domain\Validator\User\Rules;

use App\Domain\Entity\User\UserInterface;
use Respect\Validation\Rules\AbstractRule;

class UserEmailBlackDomainsRule extends AbstractRule
{
    /**
     * @var array
     */
    private const BLACK_LIST = [
        'fake-email.com',
        'black-email.com',
    ];

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return 'UserEmailBlackDomainsRule';
    }

    /**
     * @inheritDoc
     */
    public function validate($input): bool
    {
        /** @var UserInterface $input */
        $domain = substr($input->getEmail(), strpos($input->getEmail(), '@') + 1);
        return $this->checkInBlackList($domain);
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    private function checkInBlackList(string $name): bool
    {
        return !in_array($name, self::BLACK_LIST, true);
    }
}
