<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardPengunjungController extends Controller
{
    use EventDataTrait;

    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));
        $category = $request->query('category', 'semua');

        $events = $this->events();

        if ($search !== '') {
            $events = $events->filter(function ($event) use ($search) {
                return str_contains(strtolower($event['title']), strtolower($search))
                    || str_contains(strtolower($event['category']), strtolower($search));
            })->values();
        }

        if ($category !== 'semua') {
            $events = $events->filter(function ($event) use ($category) {
                return strtolower($event['category']) === strtolower($category);
            })->values();
        }

        $paginatedEvents = $this->paginateEvents($events, $request);

        return view('pages.pengunjung.dashboard_pengunjung', compact('paginatedEvents', 'search', 'category'));
    }

    public function ajaxSearch(Request $request)
    {
        $search = trim($request->query('search', ''));
        $category = $request->query('category', 'semua');

        $events = $this->events();

        if ($search !== '') {
            $events = $events->filter(function ($event) use ($search) {
                return str_contains(strtolower($event['title']), strtolower($search))
                    || str_contains(strtolower($event['category']), strtolower($search));
            })->values();
        }

        if ($category !== 'semua') {
            $events = $events->filter(function ($event) use ($category) {
                return strtolower($event['category']) === strtolower($category);
            })->values();
        }

        $paginatedEvents = $this->paginateEvents($events, $request);

        $html = view('pages.pengunjung.partials.dashboard_event_section', compact('paginatedEvents', 'search', 'category'))->render();

        return response()->json(['html' => $html]);
    }

    private function paginateEvents($events, Request $request)
    {
        $perPage = 4;
        $page = $request->input('page', 1);
        $currentPageItems = $events->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $events->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
    }
}
