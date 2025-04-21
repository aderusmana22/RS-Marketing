<?php

namespace App\Http\Controllers;

use App\Models\Item\Itemdetail;
use Illuminate\Http\Request;
use App\Models\Item\Itemmaster;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class ItemdetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemDetails = Itemdetail::with('itemmaster')->get();
        $itemMasters = Itemmaster::all();
         
        return view('item-details.index', compact('itemDetails', 'itemMasters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $itemMasters = Itemmaster::all();
        return view('item-details.create', compact('itemMasters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_master_id' => 'required|exists:itemmasters,id',
            'item_detail_code' => 'required|string|max:50',
            'item_detail_name' => 'required|string|max:100',
            'unit' => 'required|string|max:10',
            'net_weight' => 'required|numeric',
            'type' => 'required|string|max:50',
        ]);

        Itemdetail::create($request->all());

        Alert::success('Success', 'Item Detail Added Successfully!');
        return redirect()->route('item-details.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Itemdetail $itemdetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itemdetail $itemdetail)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itemdetail $itemdetail)
    {
        $request->validate([
            'item_master_id' => 'required|exists:itemmasters,id',
            'item_detail_code' => 'required|string|max:50',
            'item_detail_name' => 'required|string|max:100',
            'unit' => 'required|string|max:10',
            'net_weight' => 'required|numeric',
            'type' => 'required|string|max:50',
        ]);

        $itemdetail->update($request->all());

        Alert::success('Success', 'Item Detail Updated Successfully!');
        return redirect()->route('item-details.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itemdetail $itemdetail)
    {
        $itemdetail->delete();
        Alert::success('Deleted', 'Item Detail Deleted Successfully!');
        return redirect()->route('item-details.index');
    }
}
