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
        return Inertia::render('contact/contact-index');
    }

    public function admin(): Response
    {
        // TODO: Add authorization policy...

        $unreadMessages = ContactMessage::query()
            ->orderBy('created_at', 'desc')
            ->get();

        $readMessages = ContactMessage::query()
            ->onlyTrashed()
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('admin/admin-contact', [
            'unreadMessages' => $unreadMessages,
            'readMessages' => $readMessages,
        ]);
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::query()->create($request->validated());

        return redirect()->back();
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        // TODO: Add authorization policy...

        $contactMessage->delete();

        return redirect()->back();
    }
}
