<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationExport;
use App\Models\Event;

class UtilityController extends Controller
{
    public function export(Request $request, $event_id)
    {
        $event = Event::with(['forms' => function($query){
            $query->where('multiple', false)->orderBy('id');
        }])->where('id', $event_id)->first();

        $allForm = $event->forms->map(function($item){
            return [
                'name' => str_replace('[]', '', $item->name),
                'label' => $item->label,
                'model_path' => $item->model_path,
                'relation_method_name' => $item->relation_method_name,
            ];
        });

        $headers = [...$allForm];
        $fields = [...$allForm->map(function($item){
            return $item['name'];
        })];

        array_push($fields, 'is_scan');

        $objectFields = [...$allForm->map(function($item){
            return [
                'name' => $item['name'],
                'label' => $item['label'],
                'model_path' => $item['model_path'],
                'relation_method_name' => $item['relation_method_name'],
            ];
        })];

        array_unshift($headers, [
            'name' => 'registration_number',
            'label' => 'Nomer Registrasi',
        ]);
        array_unshift($fields, 'registration_number');

        $registrations = app($event->model_path)->select(...$fields)->when(request()->search, function($query){
            if (request()->filter === 'email') {
                $query->whereRelation('participant', 'name', 'LIKE', '%' . request()->search . '%');
            } else {
                $query->where(request()->filter, 'LIKE', '%' . request()->search . '%');
            }
        }) ->when(request()->scan, function($query){
            $query->where('is_scan', request()->scan == 'true' ? true : false);
        })
        ->where('fullname', '<>', '')
        ->where('event_id', $event_id)->get();

        return Excel::download(new RegistrationExport($registrations, $objectFields), 'registrations-' . $event->slug .'.xlsx');
    }
}
