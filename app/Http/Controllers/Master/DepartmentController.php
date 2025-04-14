<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Department;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'depHead');
        })->get();
        $departments = Department::with('departmentHead')->get();

        // Dialog Sweet Alert
        $title = 'Delete Department!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return \view('page.master.departments.index',\compact('users','departments'));
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
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'dep_head_id' => 'required|exists:users,id',
        ]);

        $department = Department::create($validate);
        Alert::toast('Department created successfully', 'success');
        return redirect()->route('master.department.index');
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
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'dep_head_id' => 'required|exists:users,id',
        ]);

        $department = Department::find($id)->update($validate);
        Alert::toast('Department updated successfully', 'success');
        return redirect()->route('master.department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::find($id)->delete();
        Alert::toast('Department deleted successfully', 'success');
        return redirect()->route('master.department.index');
    }
}
