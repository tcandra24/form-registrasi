<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FormField;

class FormFieldController extends Controller
{
    public function index(){
        $formFields = FormField::paginate(10);

        return view('admin.settings.form_fields.index', [ 'formFields' => $formFields ]);
    }

    public function create()
    {
        return view('admin.settings.form_fields.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'label' => 'required',
            'type' => 'required',
            'validation_rule' => 'required',
            'validation_message' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'label.required' => 'Label wajib diisi',
            'type.required' => 'Type wajib diisi',
            'validation_rule.required' => 'Rule Validasi wajib diisi',
            'validation_message.required' => 'Pesan Validasi wajib diisi',
        ]);

        try {
            $isMultiple = $request->multiple ? true : false;

            FormField::create([
                'name' => $request->name,
                'label' => $request->label,
                'type' => $request->type,
                'model_path' => $request->model_path,
                'validation_rule' => $request->validation_rule,
                'validation_message' => $request->validation_message,
                'multiple' => $isMultiple,
                'relation_method_name' => $request->relation_method_name
            ]);

            return redirect()->route('form-fields.index')->with('success', 'Form Field Berhasil Disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(FormField $formField)
    {
        try {
            return view('admin.settings.form_fields.edit', ['formField' => $formField]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, FormField $formField)
    {
        $request->validate([
            'name' => 'required',
            'label' => 'required',
            'type' => 'required',
            'validation_rule' => 'required',
            'validation_message' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'label.required' => 'Label wajib diisi',
            'type.required' => 'Type wajib diisi',
            'validation_rule.required' => 'Rule Validasi wajib diisi',
            'validation_message.required' => 'Pesan Validasi wajib diisi',
        ]);

        try {
            $isMultiple = $request->multiple ? true : false;

            $formField->update([
                'name' => $request->name,
                'label' => $request->label,
                'type' => $request->type,
                'model_path' => $request->model_path,
                'validation_rule' => $request->validation_rule,
                'validation_message' => $request->validation_message,
                'multiple' => $isMultiple,
                'relation_method_name' => $request->relation_method_name
            ]);

            return redirect()->route('form-fields.index')->with('success', 'Form Field Berhasil Diupdate');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $formField = FormField::findOrFail($id);
            $formField->event()->detach();
            $formField->delete();

            return redirect()->route('form-fields.index')->with('success', 'Form Field Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
