<?php
declare(strict_types=1);

namespace Youtube\Model;

use DateTime;

final class User
{
    private int $id;
    private string $email;
    private string $password;
    private DateTime $createdAt;

    public function __construct(
        string $email,
        string $password,
        DateTime $createdAt
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}