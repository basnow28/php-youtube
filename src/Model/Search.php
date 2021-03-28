<?php
declare(strict_types=1);

namespace Youtube\Model;

use DateTime;

final class Search
{
    private int $id;
    private int $user_id;
    private string $search;
    private DateTime $created_at;

    public function __construct(
        int $user_id,
        string $search,
        DateTime $created_at
    ) {
        $this->user_id = $user_id;
        $this->search = $search;
        $this->created_at = $created_at;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }


    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setSearch(string $search): void
    {
        $this->search = $search;
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

    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }
}