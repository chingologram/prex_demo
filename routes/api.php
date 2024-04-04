<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\GifsController;

// This /login route generates a personal access token similar to oauth.token with grant_type=client_credentials
Route::get('/login', function (Request $request)
{
    $user = User::where('email', $request->input('email'))
        ->first();
    if ($user && Hash::check($request->input('password'), $user->password)) {
        $tokenData = $user->createToken(env('APP_NAME'));
        return response()->json([
            'access_token' => $tokenData->accessToken,
            'expires_at' => $tokenData->token->expires_at,
        ], 200);
    }
    return response()->json(['error' => 'Invalid credentials.'], 401);
});

Route::get('/gifs', [ GifsController::class, 'search' ])->middleware('auth:api');

Route::get('/gifs/byID', [ GifsController::class, 'findById' ])->middleware('auth:api');

Route::get('/gifs/favorite', [ GifsController::class, 'favorite' ])->middleware('auth:api');
