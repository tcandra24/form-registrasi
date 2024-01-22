<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;


class IndexController extends Controller
{
    public function index()
    {
        $events = Event::where('is_active', true)->get();
        return view('transactions.index', [ 'events' => $events]);
    }
}
