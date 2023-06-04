<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Requests\Api\UserRegisterRequest;
use App\Services\Api\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"User Information"},
     *     description="User login",
     *      @OA\RequestBody(
     *          required=true,
     *              @OA\JsonContent(
     *                   @OA\Property(property="email", type="string", example="nva@gmail.com"),
     *                   @OA\Property(property="password", type="string", example="***"),
     *               ),
     *      ),     
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Authorized"
     *     ),
     * )
     */
    public function authenticate(UserLoginRequest $request)
    {
        $data = $request->validated();
        return $this->userService->authenticate($data);
    }

    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();
        return $this->userService->register($data)->toArray();
    }
}
