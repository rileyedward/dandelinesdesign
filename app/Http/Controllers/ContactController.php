<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use Inertia\Response;

class ContactController extends Controller
{
    public function store(ContactMessageRequest $request): Response
    {
        ContactMessage::query()->create($request->validated());

        return response()->back();
    }
}
