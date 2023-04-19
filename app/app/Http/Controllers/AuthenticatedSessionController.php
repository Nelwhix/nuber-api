<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\LoginNeedsVerification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request) {
        $request->validate([
           'mobile' => 'required|numeric|min:10'
        ]);

        $user = User::firstOrCreate([
            'mobile' => $request->mobile
        ]);

        if (!$user) {
            return response()->json([
                'message' => 'Could not process a user with that phone number'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->notify(new LoginNeedsVerification());

        return response()->json([
           'message' => 'Text message notification sent.'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $request->validate([
            'mobile' => 'required|numeric|min:10',
            'code' => 'required|numeric|between:111111,999999'
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($user->login_code !== $request->code) {
            return response()->json([
               'message' => 'Invalid verification code'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->update([
            'login_code' => null
        ]);

        $token = $user->createToken('nuber_token')->plainTextToken;

        return response()->json([
           'message' => 'successful',
           'token' => $token
        ]);
    }
}
