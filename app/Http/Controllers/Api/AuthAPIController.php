<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use App\Model\Users;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        ]);
        $errors = $validator->errors();
        if ($validator->fails()) {
            return response()->json(['error' => $errors], 401);
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

    /**
     * Login API.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function loginAsDonatur(Request $request)
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

            $users = Users::find($user->id);

            if ($users['role_id'] == 3) {
                return response()->json(['token' => $token, 'message' => $message], 200);
            } else {
                return response()->json(['error' => 'Email or Password Invalid'], 401);
            }
        } else {
            return response()->json(['error' => 'Email or Password Invalid'], 401);
        }
    }

    /**
     * Login API.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function loginAsDriver(Request $request)
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

            $users = Users::find($user->id);

            if ($users['role_id'] == 4) {
                return response()->json(['token' => $token, 'message' => $message], 200);
            } else {
                return response()->json(['error' => 'Email or Password Invalid'], 401);
            }
        } else {
            return response()->json(['error' => 'Email or Password Invalid'], 401);
        }
    }

    public function getUser()
    {
        $query = Users::find(auth('api')->user()->id);

        return new UsersResource($query);
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
            $user->update(['password' => Hash::make($request->password)]);
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
     * Update Profile.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Users::find(auth('api')->user()->id);

        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateFileName(auth('api')->user()->id).'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('public')->put('profile/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        if ($request->name != '') {
            $user->name = $request->name;
        }
        if ($request->email != '') {
            $user->email = $request->email;
        }
        if ($request->file) {
            $user->file_name = $file_name;
        }

        $user->save();

        return response()->json(['message' => 'Change Profile Success'], 200);
    }

    /**
     * @return string
     */
    public function generateFileName($id)
    {
        $date = Carbon::now()->toDateString();
        $clock = Carbon::now()->toTimeString();

        return 'profile_id_'.$id.'_'.$date.'_'.$clock;
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
