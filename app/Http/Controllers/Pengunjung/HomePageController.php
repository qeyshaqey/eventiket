<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class HomePageController extends Controller
{
    use EventDataTrait;

    public function index(Request $request)
    {
        $events = $this->events();
        $perPage = 4;
        $page = $request->input('page', 1);
        $currentPageItems = $events->slice(($page - 1) * $perPage, $perPage)->values();

        $paginatedEvents = new LengthAwarePaginator(
            $currentPageItems,
            $events->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );
        return view('Pengunjung.home_page', compact('paginatedEvents'));
    }

    public function showDetail($id)
    {
        $event = $this->events()->firstWhere('id', (int) $id);

        if (!$event) {
            abort(404);
        }

        return view('Pengunjung.detail_event', compact('event'));
    }
}