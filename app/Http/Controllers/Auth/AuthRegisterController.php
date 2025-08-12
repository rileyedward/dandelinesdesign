<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class AuthRegisterController extends Controller
{
    public function index(Request $request): Response
    {
        return inertia('auth/auth-register');
    }

    public function store(AuthRegisterRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());

        return to_route('home');
    }
}
