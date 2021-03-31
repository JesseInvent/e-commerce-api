<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    protected function getAndReturnUserToken($user)
    {
        $token = $user->createToken('accessToken', ['admin'])->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }

    public function  signup(SignupRequest $request)
    {
        $user = User::create($request->all());

        return $this->getAndReturnUserToken($user);

    }

    public function login(Request $request)
    {
        if(Auth::attempt($request->all())) {

            $user = User::where('email', $request->email)->first();
            return $this->getAndReturnUserToken($user);

        }

        return response()->json(['error' => 'Unauthorized'], Response::HTTP_BAD_REQUEST);

    }

}
