<?php

namespace App\Exports;

use App\Models\RegistrationMechanic;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RegistrationMechanicTrashExport implements FromView
{
    protected $is_scan;

    public function __construct($is_scan)
    {
        $this->is_scan = $is_scan;
    }

    /**
    * @return Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        $registrations = RegistrationMechanic::onlyTrashed()->where('fullname', '<>', '');

        if(request()->has('is_scan') && request('is_scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('is_scan'));
        }

        $registrations = $registrations->get();

        return view('exports.registration-mechanic', [
            'registrations' => $registrations,
        ]);
    }
}
