<?php

namespace App\Http\Controllers\Rs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Approver;
use App\Models\RS\RSMaster;
use App\Models\RS\RSItem;
use App\Models\Item\Itemmaster;
use App\Models\Customer;
use App\Models\User;
use App\Models\RsApproval;
use App\Models\Item\Itemdetail;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendRsApprovalEmail;


class RequistionSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = RSMaster::get();
        return \view('page.rs.list-rs', compact('req'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Itemmaster::all();
        $customers = Customer::all();
        $initiators = User::all();
        return \view('page.rs.submitform-rs', compact('items', 'customers', 'initiators'));
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
        // dd($request->all());

        try {
            $request->validate([
                'rs_no' => 'required|string|max:50',
                'category' => 'required|string|max:255',
                'customer_id' => 'required|numeric',
                'address' => 'required|string|max:255',
                'objectives' => 'nullable|string|max:255',
                'reason' => 'nullable|string|max:255',
                'account' => 'required|string|max:50',
                'cost_center' => 'nullable|string|max:50',
                'batch_code' => 'nullable|string|max:50',
                'revision_id' => 'required|string|max:50',
                'rs_number' => 'nullable|string|max:50',
                'est_potential' => 'nullable|string|max:50',
                'date' => 'required|date',
                'initiator_nik' => 'required|string|max:50',
                'route_to' => 'nullable|string|max:50',
                'item_detail_id' => 'required|array|min:1',
                'item_detail_id.*' => 'numeric',
                'qty_req' => 'required|array|min:1',
                'qty_req.*' => 'numeric|min:0',
                'qty_issued' => 'required|array|min:1',
                'qty_issued.*' => 'numeric|min:0',
            ]);

            $initiator = $request->input('initiator_nik');
            $initiator = User::where('nik', $initiator)->first();
            if (!$initiator) {
                Alert::error('Error', 'Invalid initiator selected.');
                return redirect()->back()->withInput();
            }

            $approver = null;
            $approverLevel = null; // Initialize approver level
            $userRole = $initiator->getRoleNames();
            foreach ($userRole as $role) {
                $approverRoleSetup = Approver::where('role', $role)->where('level', 1)->first();
                if ($approverRoleSetup) {
                    $approver = User::where('nik', $approverRoleSetup->nik)->first();
                    if ($approver) {
                        $approverLevel = $approverRoleSetup->level; // Get the level of the first approver
                        break;
                    }
                }
            }

            Log::info('Approver search result', [
                'approver_name' => $approver ? $approver->name : 'None found',
                'approver_nik' => $approver ? $approver->nik : 'N/A',
                'initiator_nik' => $initiator->nik,
            ]);

            $rsMaster = RSMaster::create([
                'rs_no' => $request->input('rs_no'),
                'category' => $request->input('category'),
                'customer_id' => $request->input('customer_id'),
                'address' => $request->input('address'),
                'objectives' => $request->input('objectives'),
                'reason' => $request->input('reason'),
                'account' => $request->input('account'),
                'cost_center' => $request->input('cost_center'),
                'batch_code' => $request->input('batch_code'),
                'revision_id' => $request->input('revision_id'),
                'rs_number' => $request->input('rs_number'),
                'est_potential' => $request->input('est_potential'),
                'date' => $request->input('date'),
                'initiator_nik' => $initiator->nik,
                'route_to' => $approver ? $approver->nik : null,
                'status' => 'pending'
            ]);

            RSItem::create([
                'rs_id' => $rsMaster->id,
                'item_id' => $request->input('item_detail_id'),
                'qty_req' => $request->input('qty_req'),
                'qty_issued' => $request->input('qty_issued'),
            ]);

            $rsMaster->load('customer');

            $rsItemRecord = RSItem::where('rs_id', $rsMaster->id)->first();
            $rsItemsForEmail = collect();
            if ($rsItemRecord && $rsItemRecord->item_id && is_array($rsItemRecord->item_id)) {
                foreach ($rsItemRecord->item_id as $key => $itemId) {
                    $itemDetail = Itemdetail::find($itemId);
                    if ($itemDetail) {
                        $rsItemsForEmail->push((object)[
                            'item_detail_code' => $itemDetail->item_detail_code,
                            'item_detail_name' => $itemDetail->item_detail_name,
                            'unit' => $itemDetail->unit,
                            'qty_req' => $rsItemRecord->qty_req[$key] ?? 0,
                            'qty_issued' => $rsItemRecord->qty_issued[$key] ?? 0,
                        ]);
                    }
                }
            }

            $uniqueToken = (string) Str::uuid();
            $approvalToken = Crypt::encryptString($rsMaster->rs_no . '|' . $uniqueToken . '|approve');
            $rejectToken = Crypt::encryptString($rsMaster->rs_no . '|' . $uniqueToken . '|reject');

            $rsMasterId = $rsMaster->id;
            $approverNik = $approver ? $approver->nik : 'N/A';

            $approvalNotReviewLink = route('rs.approved-no-review', [
                'rs_master_id' => $rsMasterId,
                'approver_nik' => $approverNik,
                'token' => $approvalToken
            ]);

            $approvalWithReviewLink = route('rs.approved-with-review', [
                'rs_master_id' => $rsMasterId,
                'approver_nik' => $approverNik,
                'token' => $approvalToken
            ]);

            $notApproveLink = route('rs.not-approved', [
                'rs_master_id' => $rsMasterId,
                'approver_nik' => $approverNik,
                'token' => $rejectToken
            ]);

            if ($approver && $approverLevel !== null) { // Ensure approver and level are found
                Log::info('Dispatching SendRsApprovalEmail job', [
                    'approver_id' => $approver->id,
                    'rsMaster_id' => $rsMaster->id,
                    'approvalToken' => $approvalToken,
                    'rejectToken' => $rejectToken,
                    'approvalNotReviewLink' => $approvalNotReviewLink,
                    'approvalWithReviewLink' => $approvalWithReviewLink,
                    'notApproveLink' => $notApproveLink
                ]);
                dispatch(new SendRsApprovalEmail(
                    $approver,
                    $rsMaster,
                    $rsItemsForEmail,
                    $approvalToken,
                    $rejectToken,
                    $approvalNotReviewLink,
                    $approvalWithReviewLink,
                    $notApproveLink
                ));

                \activity('Requisition Slip')
                    ->performedOn($rsMaster)
                    ->causedBy(Auth::user())
                    ->log('Send approval email to ' . $approver->name . ' (' . $approver->nik . ') for Requisition Slip ' . $rsMaster->rs_no);

                // --- NEW: Create RsApproval record ---
                RsApproval::create([
                    'rs_no' => $rsMaster->rs_no,
                    'nik' => $approver->nik,
                    'level' => $approverLevel, // The level of the current approver
                    'status' => 'pending', // Initial status for this approval step
                    'token' => $uniqueToken, // Using the approval token for this step
                ]);
                Log::info('RsApproval record created for first approver: ' . $approver->nik . ' Level: ' . $approverLevel);
                // --- END NEW ---

            } else {
                Log::warning('No initial approver found for requisition slip. Email approval will not be sent, and no RsApproval record created.', [
                    'rs_no' => $rsMaster->rs_no,
                    'initiator_nik' => $initiator->nik
                ]);
                // Optionally, handle what happens if no initial approver is found,
                // e.g., set status to 'needs manual assignment'
                $rsMaster->update(['status' => 'needs_assignment']);
            }

            \activity('Requisition Slip')
                ->performedOn($rsMaster)
                ->causedBy(Auth::user())
                ->log('Create Requisition Form ' . $request->input('rs_no') . ' by ' . (Auth::user() ? Auth::user()->name : 'unknown') . ' at ' . now());

            Alert::success('Success', 'Requisition Slip has been created successfully');
            return redirect()->route('rs.index');
        } catch (\Exception $e) {
            Log::error('Failed to create Requisition Slip: ' . $e->getMessage(), ['exception' => $e, 'request_data' => $request->all()]);
            Alert::error('Error', 'Failed to create Requisition Slip: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function detail($id)
    {
        $master = RSMaster::with('rs_items')->where('rs_no', $id)->firstOrFail();
        // \dd($master);
        return view('page.rs.form-list-rs', compact('master'));
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
            'rs_number' => 'nullable|string|max:50|unique:rs_masters,rs_number,' . $id,
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

    public function list($id)
    {
        $master = RSMaster::with('rs_items')->findOrFail($id);


        return view('page.rs.form-list-rs', compact('master'));
    }



    public function getFormList($nik = null)
    {
        $user = Auth::user();
        $query = RSMaster::with(['initiator', 'customer', 'revisions', 'rs_items']);
        $isSuperAdmin = method_exists($user, 'hasRole') ? $user->hasRole('super-admin') : false;
        if ($isSuperAdmin) {
            $formList = $query->get();
        } else {
            if ($nik) {
                $nik = ucfirst(strtolower($nik));
                $formList = $query->where('route_to', $nik)->get();
            } else {
                $formList = $query->where('route_to', $user->nik)->get();
            }
        }
        if ($formList) {
            $formList = $formList->map(function ($item) {
                $user = \App\Models\User::where('nik', $item->route_to)->first();
                $item->route_to_name = $user ? $user->name : $item->route_to;
                $item->new_created_at = $item->created_at ? $item->created_at->format('d-m-Y') : '';
                $item->customer = $item->customer ?? (object)[];
                $item->revisions = $item->revisions ?? (object)[];
                $item->rs_items = collect($item->rs_items)->map(function ($rs_item) {
                    // Cast ke array jika masih string JSON
                    $rs_item->item_id = is_array($rs_item->item_id) ? $rs_item->item_id : (is_string($rs_item->item_id) ? json_decode($rs_item->item_id, true) : []);
                    $rs_item->qty_req = is_array($rs_item->qty_req) ? $rs_item->qty_req : (is_string($rs_item->qty_req) ? json_decode($rs_item->qty_req, true) : []);
                    $rs_item->qty_issued = is_array($rs_item->qty_issued) ? $rs_item->qty_issued : (is_string($rs_item->qty_issued) ? json_decode($rs_item->qty_issued, true) : []);
                    // Ambil detail item, urut sesuai item_id
                    $itemDetails = [];
                    if (is_array($rs_item->item_id)) {
                        foreach ($rs_item->item_id as $id) {
                            $detail = \App\Models\Item\Itemdetail::find($id);
                            $itemDetails[] = $detail ? $detail : (object)[];
                        }
                    }
                    $rs_item->item_detail = $itemDetails;
                    return $rs_item;
                })->values()->toArray();
                return $item;
            });
            return response()->json($formList->values());
        }
        return response()->json(["message" => "No data found"]);
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
        $item = $item->get();
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

    public function print($no)
    {
        $form = RSMaster::with('initiator', 'revisions', 'customer', 'rs_items')->where('rs_no', $no)->first();
        if (!$form) {
            return redirect()->back()->with('error', 'Requisition Slip not found');
        }

        // Mapping agar rs_items dan item_detail urut dan tidak null
        $form->rs_items = collect($form->rs_items)->map(function ($rs_item) {
            $rs_item->item_id = is_array($rs_item->item_id) ? $rs_item->item_id : (is_string($rs_item->item_id) ? json_decode($rs_item->item_id, true) : []);
            $rs_item->qty_req = is_array($rs_item->qty_req) ? $rs_item->qty_req : (is_string($rs_item->qty_req) ? json_decode($rs_item->qty_req, true) : []);
            $rs_item->qty_issued = is_array($rs_item->qty_issued) ? $rs_item->qty_issued : (is_string($rs_item->qty_issued) ? json_decode($rs_item->qty_issued, true) : []);
            // Ambil detail item, urut sesuai item_id
            $itemDetails = [];
            if (is_array($rs_item->item_id)) {
                foreach ($rs_item->item_id as $id) {
                    $detail = \App\Models\Item\Itemdetail::find($id);
                    $itemDetails[] = $detail ? $detail : (object)[];
                }
            }
            $rs_item->item_detail = $itemDetails;
            return $rs_item;
        })->values()->toArray();

        return view('page.rs.print-rs', compact('form'));
    }
}
