<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class LinkController extends Controller
{
    public function show($slug)
    {
        if(!$slug){
            abort(404);
        }

        $event = Event::where('slug', $slug)->where('is_active', true);
        if(!$event->exists()){
            abort(404);
        }

        $event = $event->first();
        return view('link.index', [ 'event' => $event ]);
    }
}