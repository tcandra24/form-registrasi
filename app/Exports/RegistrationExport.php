<?php

namespace App\Exports;

use App\Models\Registration;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationExport implements FromView
{
    protected $event;

    public function __construct($event)
    {
        $this->event = $event;
    }
    /**
    * @return Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        $registrations = Registration::where('fullname', '<>', '')->where('event_slug', $this->event)->get();

        return view('exports.registrations', [
            'registrations' => $registrations,
        ]);
    }
}
