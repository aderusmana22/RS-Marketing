<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Revisions;
use RealRashid\SweetAlert\Facades\Alert;

class RevisionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $revisions = Revisions::all();
        return view('page.masterdata.revisions.index', compact('revisions'));
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

        Revisions::create($request->all());
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
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'form_no' => 'required|string|max:255',
            'revision' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
    
        $revision = Revisions::findOrFail($id);
        $revision->update([
            'form_no' => $request->form_no,
            'revision' => $request->revision,
            'date' => $request->date,
        ]);
        Alert::success('Updated', 'Revision updated successfully');
        return redirect()->route('revisions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $revision = Revisions::findOrFail($id);
        $revision->delete();
        // Dialog Sweet Alert
        Alert::success('Deleted', 'Revision deleted successfully');
        return redirect()->route('revisions.index');
    } 
}
