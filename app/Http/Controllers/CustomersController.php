<?php

namespace App\Http\Controllers;

use App\Models\customers;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = customers::all();
        return view('page.masterdata.customers.index', compact('customers'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        customers::create($validated);
        Alert::toast('Successfully added customer', 'success');
        return redirect()->route('customers.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, customers $customers)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        $customer->update($validated);
        Alert::toast('Customer updated successfully', 'success');
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customers $customers)
    {
        // Hapus customer
        $customers->delete();

        // Dialog Sweet Alert
        Alert::toast('Customer deleted successfully!', 'success');
        return redirect()->route('customers.index');
    }
}
