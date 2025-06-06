<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    public function submit(Request $request): RedirectResponse
    {
        $request->validate([
            'passcode' => 'required|string',
        ]);

        $correctPasscode = config('site.passcode');

        if ($request->input('passcode') === $correctPasscode) {
            session(['passcode_authenticated' => true]);

            return redirect()->intended('/');
        }

        return back()->withErrors(['passcode' => 'Incorrect passcode.']);
    }
}
