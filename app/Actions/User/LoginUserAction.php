<?php

namespace App\Actions\User;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class LoginUserAction
{
    public function handle(array $data): ?Authenticatable
    {
        if (!Auth::guard('web')->attempt($data)) {
            return null;
        }

        return Auth::user();
    }
}
