<?php

namespace App\Exports;

use App\Models\Registration;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationExport implements FromView
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
        ->where('fullname', '<>', '')->get();

        return view('exports.registrations', [
            'registrations' => $registrations,
        ]);
    }
}
