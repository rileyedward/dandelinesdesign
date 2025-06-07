<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageViewController extends Controller
{
    /**
     * Display a listing of the page views.
     */
    public function index()
    {
        $pageViews = PageView::latest()->paginate(15);

        return Inertia::render('admin/page-views/page-views-index', [
            'pageViews' => $pageViews,
        ]);
    }

    /**
     * Get the count of unique visitors.
     */
    public function count()
    {
        $count = PageView::count();

        return response()->json(['count' => $count]);
    }
}
