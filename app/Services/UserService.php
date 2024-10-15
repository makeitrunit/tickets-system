<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct()
    {
    }

    public function getUserForPurchaseByEmail($email): ?User
    {
        try {
            $user = User::byEmail($email)->first();

            if (!$user) {
                $user = User::createFromEmail($email);
            }
            return $user;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return null;
    }
}
