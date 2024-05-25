<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\RegistrationMechanic;
use App\Models\User;
use App\Models\Shift;
use App\Models\Event;
use Carbon\Carbon;

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

    public function showOnMonitor()
    {
        // $usersShowRegistrations = User::where('is_display', true)->with(['registrationsMechanicByCreateBy' => function($query){
        //     $query->orderBy('created_at', 'desc');
        // }])->get()->map(function($registration){
        //     $registration->setRelation('registrationsMechanicByCreateBy', $registration->registrationsMechanicByCreateBy->take(5));
        //     return $registration;
        // });

        $usersShowRegistrations = User::where('is_display', true)->get();

        // $registrationsIsScan = RegistrationMechanic::where('is_scan', true)->orderBy('fullname')->take(20)->get();
        // $registrationsNotScan = RegistrationMechanic::where('is_scan', false)->orderBy('fullname')->take(20)->get();

        // $countRegistrationsIsScan = RegistrationMechanic::where('is_scan', true)->count();
        // $countRegistrationsNotScan = RegistrationMechanic::where('is_scan', false)->count();
        // $countRegistrationsNow = RegistrationMechanic::whereDate('created_at', Carbon::now())->count();
        // $countWorkshop = RegistrationMechanic::select('workshop_name')->groupBy('workshop_name')->get()->count();

        return view('show-on-monitor.index', [
            'usersShowRegistrations'    => $usersShowRegistrations,
            // 'registrationsIsScan'       => $registrationsIsScan,
            // 'registrationsNotScan'      => $registrationsNotScan,
            // 'countRegistrationsIsScan'  => $countRegistrationsIsScan,
            // 'countRegistrationsNotScan' => $countRegistrationsNotScan,
            // 'countRegistrationsNow'     => $countRegistrationsNow,
            // 'countWorkshop' => $countWorkshop
        ]);
    }
}
