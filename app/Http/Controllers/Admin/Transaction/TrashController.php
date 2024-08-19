<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

class TrashController extends Controller
{
    public function show($event_id)
    {
        try {
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

            $registrations = app($event->model_path)->onlyTrashed()->select(...$fields)->when(request()->search, function($query){
                if (request()->filter === 'email') {
                    $query->whereRelation('user', 'name', 'LIKE', '%' . request()->search . '%');
                } else {
                    $query->where(request()->filter, 'LIKE', '%' . request()->search . '%');
                }
            }) ->when(request()->scan, function($query){
                $query->where('is_scan', request()->scan == 'true' ? true : false);
            })
            ->when(request()->shift, function($query){
                $query->where('shift_id', request()->shift);
            })
            ->where('event_id', $event_id)->paginate(10);

            return view('admin.transactions.trash.show', [
                'fields' => $objectFields,
                'registrations' => $registrations,
                'event' => $event
            ]);
        } catch (\Exception $e) {
            return redirect()->route('transaction.trash.show', $event)->with('error', $e->getMessage());
        }
    }

    public function restore($event_id, $registration_number)
    {
        try {
            $event = Event::where('id', $event_id)->first();
            app($event->model_path)->onlyTrashed()->where('event_id', $event_id)->where('registration_number', $registration_number)->restore();

            return redirect()->route('transaction.trash.show', $event)->with('success', 'Data Registrasi Berhasil Dipulihkan');
        } catch (\Exception $e) {
            return redirect()->route('transaction.trash.show', $event)->with('error', $e->getMessage());
        }
    }
}
