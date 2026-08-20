<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthServiceInterface
{
    public function login(array $credentials): array;

    public function logout(User $user): void;
}
