<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\User\Rules;

use App\Domain\Entity\User\UserInterface;
use Respect\Validation\Rules\AbstractRule;

class UserNameBlackWordsRule extends AbstractRule
{
    /**
     * @var array
     */
    private const BLACK_LIST = [
        'black_word1',
        'black_word2',
    ];

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return 'UserNameBlackWordsRule';
    }

    /**
     * @inheritDoc
     */
    public function validate($input): bool
    {
        /** @var UserInterface $input */
        return $this->checkInBlackList($input->getName());
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
