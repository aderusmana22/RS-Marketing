<?php

namespace App\Http\Controllers\Rs;

use App\Http\Controllers\Controller;
use App\Models\user\User;;
use App\Models\user\Role;
use App\Models\Master\Level;
use App\Models\Rs\Approvers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class ApproverController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $approvers = Approvers::with('user')->get();
        return view('page.rs.approvers.index', compact('approvers'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $users = User::all(); // ambil semua user untuk pilih NIK
        $roles = Role::pluck('name', 'name')->all(); // ambil semua role

        return view('page.rs.approvers.create', compact('users', 'roles'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'approver_nik' => 'required|string|max:6',
            'section_id' => 'required|integer',
            'rs_master_id' => 'required|integer'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Approvers $approvers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Approvers $approvers)
    {
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('approver.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'level' => $userRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Approvers $approvers)
    {
        //
        $request->validate([
            'nik' => 'required|string|max:6',
            'role' => 'required|string|max:50',
            'level' => 'required|integer'
        ]);
        $approvers->nik = $request->input('nik');
        $approvers->role = $request->input('role');
        $approvers->level = $request->input('level');
        $approvers->save();
        Alert::success('Success', 'Approver has been updated successfully');
        return redirect()->route('approvers.index')->with('success', 'Approver has been updated successfully');          


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $approver = Approvers::findOrFail($id);
        $approver->delete();

        Alert::success('Deleted', 'Approver has been deleted successfully');
        return redirect()->route('approvers.index');
    }
}
