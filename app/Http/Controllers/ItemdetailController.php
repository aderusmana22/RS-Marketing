<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
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
        // $itemdetails = [
        
            
            
            
        // ];
         
        // foreach ($itemdetails as $detail) {
        //     DB::table('item_details')->insert([
        //         'item_master_id' => Itemmaster::where('parent_item_code', $detail['item_detail_code'])->first()->id,
        //         'item_detail_code' => $detail['item_detail_code'],
        //         'item_detail_name' => $detail['item_detail_name'],
        //         'unit' => $detail['unit'],
        //         'net_weight' => $detail['net_weight'],
        //         'type' => $detail['type'],
        //         'created_at' => carbon::now(),
        //         'updated_at' => carbon::now(),
        //     ]);
        // }

        $itemMasters = Itemmaster::all();
        $details = Itemdetail::all();
        
         \confirmDelete();
        return view('page.masterdata.itemdetails.index', compact('details', 'itemMasters'));
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
        // \dd($request->all());
        $validate = $request->validate([
            'item_master_id' => 'required|exists:item_masters,id',
            'item_detail_code' => 'required|string|max:50',
            'item_detail_name' => 'required|string|max:100',
            'unit' => 'required|string|max:10',
            'net_weight' => 'required|numeric',
            'type' => 'required|string|max:50',
        ]);

        $details = itemdetail::create($validate);


        Alert::success('Success', 'Item Detail Added Successfully!');
        return redirect()->route('item-detail.index');
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
    public function edit(Itemdetail $id)
    {
        $details = Itemdetail::findOrFail($id->id);

        return view('page.masterdata.itemdetails.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // \dd($request->all(), $id);
        try{
          $validate = $request->validate([
            'item_master_id' => 'required|exists:item_masters,id',
            'item_detail_code' => 'required|string|max:50',
            'item_detail_name' => 'required|string|max:100',
            'unit' => 'required|string|max:10',
            'net_weight' => 'required|numeric',
            'type' => 'required|string|max:50',
        ]);

        // \dd($validate);
        $itemdetail = Itemdetail::findOrFail($id);
        $itemdetail->update($validate);



        Alert::success('Success', 'Item Detail Updated Successfully!');
        return redirect()->route('item-detail.index'); 

        }catch(\Exception $e){
            \dd($e);
            Alert::error('Error', 'Item Detail Updated Failed! ' .$e);
            return redirect()->route('item-detail.index');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemdetail = Itemdetail::findOrFail($id);
        $itemdetail->delete();

        $item = Itemdetail::where('id', $id)->first();

        if ($item) {
            Alert::error('Error', 'Item Detail Deleted Failed!');
            return redirect()->route('item-detail.index');
        }

        
        Alert::success('Deleted', 'Item Detail Deleted Successfully!');
        return redirect()->route('item-detail.index');
    }
}
