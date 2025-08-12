<?php

namespace App\Http\Controllers;

use App\Contracts\ContactMessageServiceInterface;
use App\Http\Requests\ContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Inertia\Response;

class ContactMessageController extends BaseController
{
    protected string $modelClass = ContactMessage::class;

    protected $serviceInterface = ContactMessageServiceInterface::class;

    protected ?string $requestClass = ContactMessageRequest::class;

    public function index(Request $request): Response
    {
        // TODO: Add page route...
        return inertia(null);
    }
}
