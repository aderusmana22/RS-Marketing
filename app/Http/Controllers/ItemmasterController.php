<?php

namespace App\Http\Controllers;

use App\Models\Item\Itemmaster;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ItemmasterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $items = Itemmaster::all();
        \confirmDelete();
        return view('page.masterdata.itemmaster.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // Dialog Sweet Alert
        $items = Itemmaster::all();
        return view('page.masterdata.itemmaster.create', compact('items'));
        
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validate = $request->validate([
            'parent_item_code' => 'required|string|max:255|unique:item_masters,parent_item_code',
            'parent_item_name' => 'required|string|max:255',
        ]);

        // Mulai transaction untuk memastikan integritas data
        $item = Itemmaster::create($validate);
        // Dialog Sweet Alert
        Alert::toast('Successfully added item', 'success');
        return redirect()->route('item-master.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Itemmaster $itemmaster)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itemmaster $itemmaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itemmaster $itemmaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemmaster = Itemmaster::find($id);
        $itemmaster->delete();
        Alert::toast('Successfully deleted item', 'success');
        return redirect()->route('item-master.index');
    }
}
