<?php

namespace App\Exports;

use App\Models\Registration;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationExport implements FromView
{
    protected $registrations;
    protected $fields;

    public function __construct($registrations, $fields)
    {
        $this->registrations = $registrations;
        $this->fields = $fields;
    }
    /**
    * @return Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        return view('admin.reports.exports.registrations', [
            'registrations' => $this->registrations,
            'fields' => $this->fields
        ]);
    }
}
