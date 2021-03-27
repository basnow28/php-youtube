<?php
declare(strict_types=1);

namespace Youtube\Service;

use Youtube\Model\User;

interface UserService
{
    public function save(User $user): void;
}