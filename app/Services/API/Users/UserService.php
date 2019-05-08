<?php
/**
 * Created by PhpStorm.
 * User: huzairuje
 * Date: 08/05/2019
 * Time: 17:26
 */

namespace App\Services\API\Users;

use App\Http\Requests\User\UserRegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register(UserRegisterRequest $userRegisterRequest)
    {
        DB::beginTransaction();
        $data = $this->userModel;
        $data->name = $userRegisterRequest->name;
        $data->email = $userRegisterRequest->email;
        $data->password = bcrypt($userRegisterRequest->password);

        $data->save();
        DB::commit();
        return $data;
    }

    public function login(Request $request)
    {
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $response = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];

        return $response;

    }

}
