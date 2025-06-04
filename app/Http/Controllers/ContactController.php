<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('contact-page');
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::query()->create($request->validated());

        return redirect()->back();
    }
}
