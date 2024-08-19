<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Participant;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $participant = Auth::guard('participant')->user();

        $events = Event::with([
            'registration' => function($query) use ($participant){
                $query->where('participant_id', $participant->id);
            }, 'registrationMechanic' => function($query) use ($participant){
                $query->where('participant_id', $participant->id);
            }
        ])
        ->where('is_active', true)
        ->withCount([
            'registration' => function($query) use ($participant){
                $query->where('participant_id', $participant->id);
            },
            'registrationMechanic' => function($query) use ($participant){
                $query->where('participant_id', $participant->id);
            },
        ])->get();

        // return response()->json($events);
        $events = $events->map(function($query){
            $array = [];
            $registration_number = '';
            if($query->registration_count > 0) {
                $array = $query->registration->pluck('registration_number')->toArray();
            }elseif($query->registration_mechanic_count > 0){
                $array = $query->registrationMechanic->pluck('registration_number')->toArray();
            }

            $registration_number = count($array) > 0 ? $array[0] : '';

            $objectStd = new \stdClass();
            $objectStd->id = $query->id;
            $objectStd->name = $query->name;
            $objectStd->slug = $query->slug;
            $objectStd->image = $query->image;
            $objectStd->description = $query->description;
            $objectStd->is_registered = ($query->registration_count + $query->registration_mechanic_count) > 0 ? true : false;
            $objectStd->registration_number = $registration_number;

            return $objectStd;
        });

        // return response()->json($events);
        return view('participant.dashboard.index', ['events' => $events]);
    }
}
