<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ProfileResource;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse|Response
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials.',
        ], 401);
        }
        if (Hash::check($request->password, $user->password)) {
            $token    = $user->createToken('authToken')->plainTextToken;
            $response = [
                'user'        => new ProfileResource($user),
                'token'       => $token
            ];
            
            return response()->json([
                    'status' => 'success',
                    'data' => $response,
                ], 200);
        }
        return $this->fail('Invalid credentials.', 401);
    }


    /**
     * Creating  a new User.
     *
     * @param RegisterRequest $request
     *
     * @return Response
     */
    public function register(RegisterRequest $request)
    {
        $user                 = new User();
        $user->name           = $request->name;
        $user->email          = $request->email;
        $user->password       = Hash::make($request->password);
        $user->save();

        return $this->success('Thanks for Registration.',201);
    }

    /**
     * @return Response
     */
    public function authUser()
    {
        $user = Auth::user();
    
        return $this->success($user);
    }

  /**
   * Summary of logout
   * @param \Illuminate\Http\Request $request
   * @return JsonResponse
   */
  public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

       return $this->success([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

}
