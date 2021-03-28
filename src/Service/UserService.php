<?php
declare(strict_types=1);

namespace Youtube\Service;

use Youtube\Model\User;
use Youtube\Model\UserLogin;

interface UserService
{
    public function save(User $user): void;
    public function login(UserLogin $user): int;
}