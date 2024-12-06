<?php

namespace App\Actions\User;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function handle(array $data): string
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user->createToken('token')->plainTextToken;
    }
}
