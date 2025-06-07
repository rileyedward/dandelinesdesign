<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\PageView;
use App\Models\QuoteMessage;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    public function index(): Response
    {

        $pageViewsCountShort = PageView::query()->where('created_at', '>=', now()->subDays(7))->count();
        $pageViewsCountFull = PageView::query()->where('created_at', '>=', now()->subDays(30))->count();

        $unreadContactMessages = ContactMessage::query()->count();
        $contactMessagesThisMonth = ContactMessage::query()
            ->withTrashed()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $unreadQuoteMessages = QuoteMessage::query()->count();
        $quoteMessagesThisMonth = QuoteMessage::query()
            ->withTrashed()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        return Inertia::render('admin/admin-index', [
            'pageViewsCountShort' => $pageViewsCountShort,
            'pageViewsCountFull' => $pageViewsCountFull,
            'unreadContactMessages' => $unreadContactMessages,
            'contactMessagesThisMonth' => $contactMessagesThisMonth,
            'unreadQuoteMessages' => $unreadQuoteMessages,
            'quoteMessagesThisMonth' => $quoteMessagesThisMonth,
        ]);
    }
}
