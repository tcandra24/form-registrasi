<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

class IndexController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)->get();
        return view('reports.index', [ 'events' => $events]);
    }
}
