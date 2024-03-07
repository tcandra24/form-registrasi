<?php

namespace App\Exports;

use App\Models\Registration;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationExport implements FromView
{
    protected $shift;
    protected $scan;
    protected $event;
    protected $search;
    protected $filter;

    public function __construct($shift, $scan, $event, $search, $filter)
    {
        $this->shift = $shift;
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
        $registrations = Registration::where('event_slug', $this->event)
        ->when($this->search, function($query){
            if ($this->filter === 'email') {
                $query->whereRelation('user', 'name', 'LIKE', '%' . $this->search . '%');
            } else {
                $query->where($this->filter, 'LIKE', '%' . $this->search . '%');
            }
        })
        ->when($this->scan, function($query){
            $query->where('is_scan', $this->scan == 'true' ? true : false);
        })
        ->when($this->shift, function($query){
            $query->where('shift_id', $this->shift);
        })
        ->where('fullname', '<>', '')->get();

        return view('exports.registrations', [
            'registrations' => $registrations,
        ]);
    }
}
