<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\RegistrationMechanic;
use App\Models\User;
use App\Models\Shift;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $registration = Registration::count();
        $registrationMechanic = RegistrationMechanic::count();
        $user = User::count();
        $shift = Shift::count();
        $event = Event::count();
        $shiftWithQuota = Shift::where('is_active', true)->withCount('registration')->get();

        // $events = Event::withCount('users')->get();
        $events = Event::withCount('users')->withCount('registrations')->get();
        $is_registered = Registration::where('user_id', Auth::user()->id)->exists();

        return view('dashboard.index', [
            'count_registration' => $registration + $registrationMechanic,
            'events' => $events,
            'count_user' => $user,
            'count_shift' => $shift,
            'count_event' => $event,
            'is_registered' => $is_registered,
            'shifts_with_quota' => $shiftWithQuota
        ]);
    }
}
