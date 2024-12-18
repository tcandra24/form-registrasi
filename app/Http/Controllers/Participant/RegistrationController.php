<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\Event;
use App\Models\FormField;
use App\Models\Service;
use App\Models\Shift;

class RegistrationController extends Controller
{
    public function create($event_id)
    {
        $event = Event::with('forms')->where('id', $event_id)->first();
        $forms = $event->forms->map(function($form) use ($event_id) {
            $objectStd = new \stdClass();
            $objectStd->id = $form->id;
            $objectStd->name = $form->name;
            $objectStd->label = $form->label;
            $objectStd->type = $form->type;
            $objectStd->multiple = $form->multiple;

            if($form->relation_method_name === 'shift') {
                $objectStd->model = $form->model_path::where('is_active', true)->where('event_id', $event_id)->orderBy('name')->get();
            }else{
                $objectStd->model = $form->model_path ? $form->model_path::where('is_active', true)->orderBy('name')->get() : null;
            }


            return $objectStd;
        });

        return view('participant.registration.create', [ 'event' => $event, 'forms' => $forms ]);
    }

    public function store(Request $request)
    {
        $event = Event::where('id', $request->event_id)->first();

        $forms = FormField::select('name', 'validation_rule', 'validation_message', 'multiple')->whereHas('event', function($query) use ($request){
            $query->where('event_id', $request->event_id);
        })->get();

        $rules = [];
        $ruleMessage = [];
        $inputField = [];

        foreach($forms as $form){
            $fieldKey = str_replace('[]', '', $form->name);

            $rules[$fieldKey] = $form->validation_rule;
            $ruleMessage[$fieldKey . '.' . $form->validation_rule] = $form->validation_message;

            if(!$form->multiple){
                $inputField[$fieldKey] = $request->post($fieldKey);
            }
        }

        $request->validate($rules, $ruleMessage);

        try {
            if($forms->where('name', 'shift_id')->first()){
                $shift = Shift::select('name', 'quota')->withCount('registration')->where('id', $request->shift_id)->first();
                if(($shift->quota - $shift->registration_count) === 0){
                    return redirect()
                        ->route('create.registrations.participant', $request->event_id)
                        ->with('error', 'Kuota shift ' . $shift->name . ' sudah penuh');
                }
            }

            $participant = Auth::guard('participant')->user();
            $token = hash_hmac('sha256', Crypt::encryptString(Str::uuid() . Carbon::now()->getTimestampMs() . $participant->name), $participant->id . $participant->name);

            $length = 5;
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
            }

            QrCode::size(200)->style('round')->eye('circle')->generate($token, Storage::path('public/qr-codes/') . 'qr-code-' . $token . '.svg');
            $registration_max = app($event->model_path)->withTrashed()->where('event_id', $event->id)->count() + 1;
            $registration_number = 'EVENT-' . Str::upper($random) . '-'. str_pad($registration_max, 5, '0', STR_PAD_LEFT);

            $inputField['registration_number'] = $registration_number;
            $inputField['participant_id'] = $participant->id;
            $inputField['event_id'] = $request->event_id;
            $inputField['token'] = $token;

            $registration = app($event->model_path)->create($inputField);

            if($request->services){
                $services = Service::select('id')->whereIn('id', $request->services)->get();
                $registration->services()->attach($services);
            }

            return redirect()->route('participant.index')->with('success', 'Registrasi Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
