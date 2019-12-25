<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Users;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthAPIController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $errors = $validator->errors()->toArray();
        if ($validator->fails()) {
            return response()->json(array('errors' => $errors), 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Users::create($input);

        $token = $user->createToken('kitapunya')->accessToken;
        $message = 'Success Registered Account!';

        return response()->json(['token' => $token, 'message' => $message], 200);
    }

    /**
     * Login API.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $token = $user->createToken('kitapunya')->accessToken;
            $message = 'Login Success!';

            return response()->json(['token' => $token, 'message' => $message], 200);
        } else {
            return response()->json(['error' => 'Email or Password Invalid'], 401);
        }
    }

    public function getUser()
    {
        $user = Users::find(auth('api')->user()->id);

        return response()->json(['data' => $user], 200);
    }

    /**
     * Change Password.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changePassword(Request $request)
    {
        $user = Users::find(auth('api')->user()->id);
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->update(['password' => Hash::make($request->newPassword)]);
            $response = [
                'status' => 'Success',
                'message' => 'Successfully Password Changed',
            ];
        } else {
            $response = [
                'status' => 'Fail',
                'message' => 'Password does not match',
            ];
        }

        return response()->json($response);
    }

    /**
     * Logout API.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        auth('api')->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
