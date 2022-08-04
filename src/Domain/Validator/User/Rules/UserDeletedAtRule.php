<?php

declare(strict_types=1);

namespace App\Domain\Validator\User\Rules;

use App\Domain\Entity\User\UserInterface;
use Respect\Validation\Rules\AbstractRule;

class UserDeletedAtRule extends AbstractRule
{
    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return 'UserDeletedAtRule';
    }

    /**
     * @inheritDoc
     */
    public function validate($input): bool
    {
        /** @var UserInterface $input */
        if (null === $input->getDeletedAt()) {
            return true;
        }
        return $input->getDeletedAt()->getTimestamp() >= $input->getCreatedAt()->getTimestamp();
    }
}
