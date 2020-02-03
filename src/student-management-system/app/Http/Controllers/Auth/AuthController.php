<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Validators\AuthValidator;
use Validator;

class AuthController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function index()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        //
//    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'login_id' => 'required|exists:users',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }



        $credentials = request(['login_id', 'password']);
        if(!Auth::attempt($credentials)){
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
//            $token->expires_at = Carbon::now()->addWeeks(1);
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

        $validator = AuthValidator::userValidator($request->all(), false);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        $user = $this->createUser($request);
        $user->setStatus('Active');

        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
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

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
