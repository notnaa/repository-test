<?php

declare(strict_types=1);

namespace App\Domain\Entity\User;

use DateTimeInterface;

class User implements UserInterface
{
    /**
     * @var int|null
     */
    protected ?int $id;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $email;

    /**
     * @var DateTimeInterface
     */
    protected DateTimeInterface $createdAt;

    /**
     * @var DateTimeInterface|null
     */
    protected ?DateTimeInterface $deletedAt;

    /**
     * @var string|null
     */
    protected ?string $notes;

    /**
     * @param string $name
     * @param string $email
     * @param DateTimeInterface $createdAt
     * @param DateTimeInterface|null $deletedAt
     * @param string|null $notes
     * @param int|null $id
     */
    public function __construct(
        string $name,
        string $email,
        DateTimeInterface $createdAt,
        ?DateTimeInterface $deletedAt = null,
        ?string $notes = null,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->deletedAt = $deletedAt;
        $this->notes = $notes;
    }

    /**
     * @inheritDoc
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @inheritDoc
     */
    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    /**
     * @inheritDoc
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @inheritDoc
     */
    public function setDeletedAt(DateTimeInterface $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @inheritDoc
     */
    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }
}
