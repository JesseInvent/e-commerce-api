<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected function attemptToLoginUser(array $data)
    {

        if (!Auth::attempt($data)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_BAD_REQUEST);
        }

        return true;
    }

    protected function getAndReturnUserToken($user)
    {
        $token = $user->createToken('accessToken', ['admin'])->plainTextToken;
        return response()->json(['token' => $token], Response::HTTP_OK);
    }

    public function  signup(SignupRequest $request)
    {
        // dd($request->all());
        $user = User::create($request->all());
        $this->attemptToLoginUser($request->only('email', 'password'));

        return $this->getAndReturnUserToken($user);

    }
}
