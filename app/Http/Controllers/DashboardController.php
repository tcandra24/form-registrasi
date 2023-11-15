<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\User;
use App\Models\Shift;

class DashboardController extends Controller
{
    public function index()
    {
        $registration = Registration::count();
        $user = User::count();
        $shift = Shift::count();
        $shiftWithQuota = Shift::where('is_active', true)->withCount('registration')->get();

        $is_registered = Registration::where('user_id', Auth::user()->id)->exists();

        return view('dashboard.index', [
            'count_registration' => $registration,
            'count_user' => $user,
            'count_shift' => $shift,
            'is_registered' => $is_registered,
            'shifts_with_quota' => $shiftWithQuota
        ]);
    }
}
