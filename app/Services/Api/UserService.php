<?php

namespace App\Services\Api;

use App\Models\User;
use App\Repositories\Api\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $repository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function authenticate($data)
    {
        if (Auth::attempt($data)) {
            $currentUser = User::where('email', $data['email'])->first();
            $token = $currentUser->createToken('authUser')->plainTextToken;
            return [
                'token' => $token,
                'currentUser' => $currentUser->toArray(),
            ];
        } 
        abort(401, 'Unauthorized');
    }

    public function register($data)
    {
        
    }
}