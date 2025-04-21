<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        $tittle = 'Customers';
        $text = 'List of Customers';
        \confirmDelete('Are you sure?', 'You won\'t be able to revert this!', 'Yes, delete it!', 'No, cancel!', 'warning', 'success');
        // Dialog Sweet Alert
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
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        Customer::create($request->all());
        // Dialog Sweet Alert
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
    public function update(Request $request, $id)
    {
        $customers = Customer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
        ]);

        $customers->update($request->all());
        Alert::toast('Customer updated successfully', 'success');
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customers = Customer::findOrFail($id);
        $customers->delete();
        Alert::toast('Customer deleted successfully', 'success');
        
            return redirect()->route('customers.index');
        }
}
