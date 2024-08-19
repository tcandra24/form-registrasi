<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Event;

class RegistrationController extends Controller
{
    public function index(){
        $events = Event::where('is_active', true)->get();
        return view('admin.transactions.registrations.index', [ 'events' => $events]);
    }

    public function show($id)
    {
        try {
            $event = Event::with(['forms' => function($query){
                $query->orderBy('id');
            }])->where('id', $id)->first();

            $allForm = $event->forms->map(function($item){
                return [
                    'name' => str_replace('[]', '', $item->name),
                    'label' => $item->label,
                    'model_path' => $item->model_path,
                    'relation_method_name' => $item->relation_method_name,
                    'is_multiple' => $item->multiple ? true : false,
                ];
            });

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
                    'is_multiple' => $item['is_multiple'],
                ];
            })];

            array_push($objectFields, [
                'name' => 'is_scan',
                'label' => 'Status Scan',
                'model_path' => null,
                'relation_method_name' => null,
                'is_multiple' => false,
            ]);

            array_unshift($fields, 'registration_number');

            $registrations = app($event->model_path)->select('*')->when(request()->search, function($query){
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
            ->where('event_id', $id)->paginate(10);

            return view('admin.transactions.registrations.show', [
                'fields' => $objectFields,
                'registrations' => $registrations,
                'event' => $event
            ]);
        } catch (\Exception $e) {
            return redirect()->route('transaction.registrations.show', $event)->with('error', $e->getMessage());
        }
    }

    public function destroy($event_id, $registration_number)
    {
        try {
            $event = Event::where('id', $event_id)->first();

            $registration = app($event->model_path)->where('event_id', $event_id)->where('registration_number', $registration_number);
            $registration->delete();

            return redirect()->route('transaction.registrations.show', $event)->with('success', 'Data Registrasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->route('transaction.registrations.show', $event)->with('error', $e->getMessage());
        }
    }
}
