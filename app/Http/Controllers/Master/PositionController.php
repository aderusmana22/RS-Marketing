<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Department;
use App\Models\Master\Level;
use App\Models\Master\Position;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        $departments = Department::all();
        $levels = Level::all();
         // Dialog Sweet Alert
         $title = 'Delete User!';
         $text = "Are you sure you want to delete?";
         confirmDelete($title, $text);
        return view('page.master.positions.index', ['positions' => $positions, 'departments' => $departments,'levels' => $levels]);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'level_id' => 'required|exists:levels,id',
        ]);
        Position::create($request->all());
        Alert::toast('Successfully created position', 'success');
        return redirect()->route('positions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'level_id' => 'required|exists:levels,id',
        ]);
        Position::find($id)->update($request->all());
        Alert::toast('Successfully updated position', 'success');
        return redirect()->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Position::find($id)->delete();
        Alert::toast('Successfully deleted position', 'success');
        return redirect()->route('positions.index');
    }
}
