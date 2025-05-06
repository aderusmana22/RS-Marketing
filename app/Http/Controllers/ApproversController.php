<?php

namespace App\Http\Controllers;

use App\Models\Master\Approvers;
use Illuminate\Http\Request;

class ApproversController extends Controller
{

    public function approvalList()
    {
        return view('page.rs.approval-rs');
    }

    public function getApprovalList()
    {
        $rsList = Approvers::where('status', 'pending')->get();
        return response()->json($rsList);
    }

    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Approvers $approvers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Approvers $approvers)
    {
        //
    }
}
