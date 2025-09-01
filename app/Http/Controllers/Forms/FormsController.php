<?php

namespace App\Http\Controllers\Forms;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forms = Form::orderBy('id', 'desc')->latest()->get();

        return view('backend.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'form_name' => 'required|string|max:255',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.type' => 'required|string|in:text,number,textarea,checkbox,date',
        ]);

        Form::create([
            'form_name' => $request->form_name,
            'fields' => json_encode($request->fields),
        ]);

        return redirect()->route('forms.index')->with('success', 'Data has been create successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $forms = Form::findOrFail($id);

    //     return view('backend.forms.show', compact('forms'));
    // }
    public function show($id)
{
    $form = Form::findOrFail($id);

    // فك تشفير الحقول المخزنة كـ JSON
    $fields = json_decode($form->fields, true); // تحويل الـ JSON إلى مصفوفة

    return view('backend.forms.show', compact('form', 'fields'));
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
