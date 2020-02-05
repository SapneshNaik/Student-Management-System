<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Validators\RoleValidator;
use Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'login_id' => 'required|exists:users',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $credentials = request(['login_id', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid password'
            ], 401);
        }
//
//

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
//        if ($request->remember_me)
        //TODO: expire token immediately and see what happens on access requests and how to get new token
//            $token->expires_at = Carbon::now()->addWeeks(1);

        //TODO: Observed that eveytime I login a new token is generated, older one still being valid!,
        // should you expire older tokens? If yes, that means a user will be able to login from only one location
        // Consider short lived access tokens, pass a refresh token in login.
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
//            'expires_at' => Carbon::parse(
//                $tokenResult->token->expires_at
//            )->toDateTimeString()
        ]);
    }


    public function register(Request $request)
    {
        $validator = RoleValidator::userValidator($request->all(), false);

        if (!$request->user()->canRegisterRole($request->base_role)) {
            return response()->json([
                'message' => 'User cannot register ' . $request->base_role
            ], 400);
        }

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = $this->createUser($request);

        //student login is disable until after admission
        if(!$user->isOfType('Student')){
            $user->setStatus('Active');
        }

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    //TODO: add logout from app api, with password/OTP confirmation


    public function logout(Request $request)
    {
        //On logout only current token will be revoked
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


    /**
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request): User
    {
        $user = new User;
        $user->login_id = $request->login_id;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->alternate_phone_number = $request->alternate_phone_number;
        $user->base_role = $request->base_role;
        $user->last_updated_by = auth()->id();
        $user->password = bcrypt($request->password);
        $user->save();

        return $user;
    }

    //TODO: Password reset functionality
}
