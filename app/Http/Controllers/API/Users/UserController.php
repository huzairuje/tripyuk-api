<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Controllers\Controller;
use App\Library\ApiBaseResponse;
use App\Library\UserResponse;
use App\Services\API\Users\UserService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class UserController extends Controller
{
    protected $apiBaseResponse;
    protected $userResponse;
    protected $userService;

    public function __construct(UserService $userService,
                                ApiBaseResponse $apiBaseResponse,
                                UserResponse $userResponse)
    {
        $this->userService = $userService;
        $this->apiBaseResponse = $apiBaseResponse;
        $this->userResponse = $userResponse;
    }

    /**
     * login api
     * @param UserLoginRequest $userLoginRequest
     * @return \Illuminate\Http\Response
     */
    public function login(UserLoginRequest $userLoginRequest){
        try {
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                $response = $this->userResponse->unauthorizedEmailAndPassword();
                return response($response, Response::HTTP_UNAUTHORIZED);
            }
            $data = $this->userService->login($userLoginRequest);
            $response = $this->userResponse->singleData($data, []);
            return response($response, Response::HTTP_OK);
        } catch (Exception $e) {
            $response = $this->apiBaseResponse->errorResponse($e);
            return response($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Register api
     * @param UserRegisterRequest $userRegisterRequest
     * @return \Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $userRegisterRequest)
    {
        try {
            $data = $this->userService->register($userRegisterRequest);
            $return = $this->apiBaseResponse->singleData($data, []);
            return response($return, Response::HTTP_OK);
        } catch (Exception $e) {
            $response = $this->apiBaseResponse->errorResponse($e);
            return response($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * details user api
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        $response = $this->userResponse->singleData($user, []);
        return response($response. Response::HTTP_OK);
    }
}
