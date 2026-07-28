<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorldCupController extends Controller
{
    /**
     * Display the World Cup 2026 fixture generator page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Load official 2026 World Cup scheduling dataset from high-fidelity local storage
        $fallbackPath = storage_path('app/worldcup_matches_fallback.json');
        if (file_exists($fallbackPath)) {
            $matches = json_decode(file_get_contents($fallbackPath), true);
        } else {
            $matches = [];
        }

        return view('website.pages.worldcup.index', [
            'matches' => $matches
        ]);
    }
}
