<?php

namespace App\Exports;

use App\Models\Registration;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationExport implements FromView
{
    protected $shift;
    protected $is_scan;

    public function __construct($shift, $is_scan)
    {
        $this->shift = $shift;
        $this->is_scan = $is_scan;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $registrations = Registration::where('fullname', '<>', '');

        if(request()->has('scan') && request('scan') !== '-') {
            $registrations = $registrations->where('is_scan', request('scan'));
        }

        if(request()->has('shift') && request('shift') !== '-') {
            $registrations = $registrations->where('shift_id', request('shift'));
        }

        $registrations = $registrations->get();

        return view('exports.registrations', [
            'registrations' => $registrations,
        ]);
    }
}
