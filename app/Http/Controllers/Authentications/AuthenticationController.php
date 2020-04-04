<?php

namespace App\Http\Controllers\Authentications;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use App\Http\Requests\Authentications\{AuthenticateRequest, RegisterRequest};

class AuthenticationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function authenticate(AuthenticateRequest $request)
    {
        $attempt = auth()->guard('web')->attempt($request->validated());
        abort_unless($attempt, Response::HTTP_UNAUTHORIZED, 'whoops! invalid admin credential has been used!');

        /** @var User $user */
        $user = auth()->guard('web')->user();
        abort_unless($user->is_active, Response::HTTP_UNAUTHORIZED, 'whoops! inactive account');

        $token = $user->createToken('web')->accessToken;

        return response()->json([
            'message' => 'authenticated successful',
            'result' => $user,
            'token' => $token
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = new User($request->validated());

        $user->save([
            'password' => bcrypt($request->get('password')),
            'role_id' => 1,
            'region_id' => 1,
        ]);

        return response()->json([
            'message' => 'registered successfully',
            'result' => $user
        ]);
    }
}
