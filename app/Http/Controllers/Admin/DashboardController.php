<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Registration;
use App\Models\RegistrationMechanic;
use App\Models\Participant;
use App\Models\Shift;
use App\Models\Event;
use App\Models\User;

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
        $users = User::count();
        $events = Event::where('is_active', true)->get();

        $eventWithModel = collect([]);
        foreach($events as $event){
            $model = app($event->model_path)->where('event_id', $event->id);

            $objectStd = new \stdClass();
            $objectStd->name = $event->name;
            $objectStd->count_participant_register = $model->count();
            $objectStd->count_participant_scan = $model->where('is_scan', true)->count();

            $eventWithModel->push($objectStd);
        }

        return view('admin.dashboard.index', [
            'count_event' => $events->count(),
            'count_user' => $users,
            'events' => $eventWithModel,
        ]);
    }
}
