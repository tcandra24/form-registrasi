<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\FormField;

class QrCodeController extends Controller
{
    public function index()
    {
        $participant = Auth::guard('participant')->user();

        $events = Event::where('is_active', true)->get();

        $registrations = collect([]);
        foreach($events as $event){
            $dataRegistration = app($event->model_path)->select('event_id', 'registration_number', 'token')
            ->with('event')
            ->where('event_id', $event->id)
            ->where('participant_id', $participant->id)->first();

            if($dataRegistration){
                $registrations->push($dataRegistration);
            }
        }

        return view('participant.qr-code.index', ['registrations' => $registrations]);
    }

    public function show($event_id, $no_registration)
    {
        $event = Event::where('id', $event_id)->first();

        $forms = FormField::select('name', 'multiple', 'label', 'model_path', 'relation_method_name')->whereHas('event', function($query) use ($event_id){
            $query->where('event_id', $event_id);
        })->get();

        $registration = app($event->model_path)->where('registration_number', $no_registration)->first();

        $fields = collect([]);

        foreach($forms as $form){
            $value = null;
            if(isset($form->model_path)){
                if ($form->multiple) {
                    $value = $registration->{$form->relation_method_name};
                } else {
                    $value = $registration->{$form->relation_method_name}->name;
                }
            } else {
                $value = $registration->{$form->name};
            }

            $objectStd = new \stdClass();
            $objectStd->title = $form->label;
            $objectStd->value = $value;

            $fields->push($objectStd);
        }

        return view('participant.qr-code.show', ['event' => $event, 'fields' => $fields, 'token' => $registration->token]);
    }
}
