<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use DateTimeInterface;

interface UserInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     */
    public function setEmail(string $email): void;

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * @return DateTimeInterface|null
     */
    public function getDeletedAt(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface $deletedAt
     */
    public function setDeletedAt(DateTimeInterface $deletedAt): void;

    /**
     * @return string|null
     */
    public function getNotes(): ?string;

    /**
     * @param string|null $notes
     */
    public function setNotes(?string $notes): void;
}
