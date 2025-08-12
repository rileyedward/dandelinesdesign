<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthPasswordResetRequest;
use Illuminate\Http\RedirectResponse;
use ILluminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthPasswordResetController extends Controller
{
    public function __invoke(AuthPasswordResetRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back();
    }
}
