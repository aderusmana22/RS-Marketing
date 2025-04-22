<?php

namespace App\Http\Controllers\Rs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RS\RSMaster;
use App\Models\Item\Itemmaster;
use App\Models\Customer;
use App\Models\User;
use App\Models\RsApproval;
use App\Models\Item\Itemdetail;
use RealRashid\SweetAlert\Facades\Alert;


class RequistionSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = RSMaster::with('rs_items')->get();
        return \view('page.rs.list-rs',compact('req'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Itemmaster::all();
        $customers = Customer::all();
        $initiators = User::all();
        return \view('page.rs.submitform-rs',compact('items','customers','initiators'));

    }

    public function noReg()
    {
        $year = date('y');
        $prefix = "{$year}RS";
        $lastRs = RsMaster::where('rs_no', 'like', "{$prefix}%")->orderBy('rs_no', 'desc')->first();

        if ($lastRs) {
            $lastNo = (int)substr($lastRs->rs_no, -4);
            $newNo = $lastNo + 1;
        } else {
            $newNo = 1;
        }

        do {
            $newNoReg = $prefix . str_pad($newNo, 4, '0', STR_PAD_LEFT);
            $existingRs = RsMaster::where('rs_no', $newNoReg)->first();
            if ($existingRs) {
                $newNo++;
            }
        } while ($existingRs);

        return response()->json(['rs_no' => $newNoReg]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());

        $request->validate([
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'rs_number' => 'required|string|max:50',
            'objectives' => 'required|string|max:255',
            'account' => 'required|string|max:50',
            'cost_center' => 'required|string|max:50',
            'form_no' => 'required|string|max:50',
            'revision' => 'required|string|max:50',
            'date' => 'required|date',
            'approvers' => 'required|array',
            'approvers.*.nik' => 'required|string|max:50',
            'approvers.*.level' => 'required|string|max:50',


        ]);

        $initiator = $request->input('initiator_nik');
        $initiator = User::where('nik', $approver)->first();
        if (!$initiator) {
            return response()->json(['error' => 'Invalid approver'], 422);
        }

        $approver = null;
        $userRole = $approver->getRoleNames();
        foreach ($userRole as $role) {
            $approverRole = RsApproval::where('role', $role)->where('level', 1)->first();
            if ($approverRole) {
                $approver = User::where('nik', $approverRole->nik)->first();
                if ($approver) break;
            }
        }
        
        

        // Mulai transaction untuk memastikan integritas data
        $req =RsMaster::create($request->all());
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       return view('page.rs.form-rs');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        confirmDelete();
        return \view('page.rs.edit-rs')->with('id', $id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'rs_number' => 'required|string|max:50|unique:rs_masters,rs_number,' . $id,
            'objectives' => 'required|string|max:255',
            'account' => 'required|string|max:50',
            'cost_center' => 'required|string|max:50',
            'form_no' => 'required|string|max:50',
            'revision' => 'required|string|max:50',
            'date' => 'required|date',
        ]);

        $req = RSMaster::findOrFail($id);
        $req->update($request->all());

        return redirect()->route('rs.index')->with('success', 'Requisition Slip succesfully updated');
    }

    /**p
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $req = RSMaster::findOrFail($id);
        $req->delete();

        return redirect()->route('rs.index')->with('success', 'Requisition Slip succesfully Deleted');
    }

    public function report()
    {
        return view('page.rs.report-rs');
    }

    public function approval()
    {
        return view('page.rs.approval-rs');
    }

    public function log()
    {
        return view('page.rs.log-rs');
    }

    public function list()
    {
        return view('page.rs.form-list-rs');
    }

    public function statusform()
    {
        return view('page.rs.formstatus-rs');
    }

    public function submitform()
{
    return view('page.rs.submitform-rs');
}

public function getproductdata($id, Request $request)
{

    $types = $request->input('types');

    $item = Itemdetail::where('item_master_id', $id);


    if ($types) {
        $item->where('type', $types);
    }
    $item = $item->first();
    if ($item) {
        return response()->json([
            'status' => 'success',
            'data' => $item
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Item not found'
        ]);
    }
}
    
}
