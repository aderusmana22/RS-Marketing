<?php

namespace App\Http\Controllers\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class revisionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $revisions = revision::all();
        return view('page.masterdata.revisions', compact('revisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'form_no' => 'required|string|max:255',
            'revision' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Revision::create($request->all());
        Alert::success('Success', 'Revision added successfully');
        return redirect()->route('revisions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customers $customers)
    {
        $revision = Revision::findOrFail($id);
        return view('page.masterdata.revisions.edit', compact('revision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customers $customers)
    {
        $request->validate([
            'form_no' => 'required|string|max:255',
            'revision' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
    
        $revision = Revision::findOrFail($id);
        $revision->update([
            'form_no' => $request->form_no,
            'revision' => $request->revision,
            'date' => $request->date,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customers $customers)
    {
        $revision = Revision::findOrFail($id);
        $revision->delete();
        // Dialog Sweet Alert
        Alert::success('Deleted', 'Revision deleted successfully');
        return redirect()->route('revisions.index');
    } 
}
