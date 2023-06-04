<?php

namespace App\Repositories\Api\Eloquent;

use App\Models\User;
use App\Repositories\Api\Eloquent\BaseRepository;
use App\Repositories\Api\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}