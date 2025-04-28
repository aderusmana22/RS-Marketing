<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Master\Level;
use App\Models\Approver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $approvers = Approver::all();
        $users = User::all();
        $roles = Role::pluck('name', 'name')->all(); // ambil semua role
        $levels = Level::pluck('name', 'name')->all(); // ambil semua level

        \confirmDelete();
        return view('page.rs.approver', compact('approvers', 'users', 'roles', 'levels'));
       
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

        DB::beginTransaction();
        try {
            $request->validate([
                'nik' => 'required|string|max:61|unique:rs_approver,nik',
                'role' => 'nullable|string|max:50',
                'level' => 'required|integer|max:50'
            ]);
             
            $approver = Approver::create([
                'nik' => $request->input('nik'),
                'role' => $request->input('role'),
                'level' => $request->input('level')
            ]);

            DB::commit();
            Alert::success('Success', 'Approver has been created successfully');
            return redirect()->route('rs.approver')->with('success', 'Approver has been created successfully');

            
        } catch (\Exception $e) {
            DB::rollback();
            \dd($e);
            Alert::error('Error', 'Failed to create approver');
            return redirect()->back()->withInput();
        }
        // $request->validate([
        //     'nik' => 'required|string|max:61|unique:rs_approver,nik',
        //     'role' => 'required|integer|max:50|unique:rs_approver,role',
        //     'level' => 'required|integer|max:50|unique:rs_approver,level'
        // ]);
         
        // $approver = Approver::create([
        //     'nik' => $request->input('nik'),
        //     'role' => $request->input('role'),
        //     'level' => $request->input('level')
        // ]);

        // $approver->syncRoles($request->role);

        // Alert::success('Success', 'Approver has been created successfully');
        // return redirect()->route('rs.approver.index')->with('success', 'Approver has been created successfully');

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
    public function edit(Approver $approvers)
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
    public function update(Request $request, Approver $approvers)
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
        return redirect()->route('rs.approver')->with('success', 'Approver has been updated successfully');          


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $approver = Approver::findOrFail($id);
        $approver->delete();

        Alert::success('Deleted', 'Approver has been deleted successfully');
        return redirect()->route('rs.approver');
    }
}
