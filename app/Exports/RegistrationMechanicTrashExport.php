<?php

namespace App\Exports;

use App\Models\RegistrationMechanic;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RegistrationMechanicTrashExport implements FromView
{
    protected $is_scan;
    protected $event;

    public function __construct($is_scan, $event)
    {
        $this->is_scan = $is_scan;
        $this->event = $event;
    }

    /**
    * @return Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        $registrations = RegistrationMechanic::onlyTrashed()->where('event_slug', $this->event)->where('fullname', '<>', '');

        if(request()->has('is_scan') && request('is_scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('is_scan'));
        }

        $registrations = $registrations->get();

        return view('exports.registration-mechanic', [
            'registrations' => $registrations,
        ]);
    }
}
