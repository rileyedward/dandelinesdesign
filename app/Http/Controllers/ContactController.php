<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Inertia\Response;

class ContactController extends Controller
{
    public function store(ContactRequest $request): Response
    {
        return response()->back();
    }
}
