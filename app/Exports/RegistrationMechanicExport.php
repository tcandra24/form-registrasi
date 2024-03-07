<?php

namespace App\Exports;

use App\Models\RegistrationMechanic;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RegistrationMechanicExport implements FromView
{
    protected $scan;
    protected $event;
    protected $search;
    protected $filter;

    public function __construct($scan, $event, $search, $filter)
    {
        $this->scan = $scan;
        $this->event = $event;
        $this->search = $search;
        $this->filter = $filter;
    }

    /**
    * @return Illuminate\Contracts\View\View
    */
    public function view(): View
    {
        $registrations = RegistrationMechanic::when($this->search, function($query){
            if ($this->filter === 'email') {
                $query->whereRelation('user', 'name', 'LIKE', '%' . $this->search . '%');
            } else {
                $query->where($this->filter, 'LIKE', '%' . $this->search . '%');
            }
        })
        ->when($this->scan, function($query){
            $query->where('is_scan', $this->scan == 'true' ? true : false);
        })
        ->where('event_slug', $this->event)->where('fullname', '<>', '')->get();

        return view('exports.registration-mechanic', [
            'registrations' => $registrations,
        ]);
    }
}
