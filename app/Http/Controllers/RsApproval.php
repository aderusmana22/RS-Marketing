<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Jobs\SendRsApprovalEmail;
use App\Models\RS\RSMaster;
use App\Models\User;

class RsApproval extends Controller
{

    public function approve($token)
{
    try {
        $decrypted = Crypt::decryptString($token);
        [$rsNo, $uniqueToken, $action] = explode('|', $decrypted);

        if ($action !== 'approve') {
            abort(403, 'Invalid action.');
        }

        $rsMaster = RsMaster::where('rs_no', $rsNo)->firstOrFail();
        
        // Cari approver saat ini berdasarkan route_to
        $approver = User::where('nik', $rsMaster->route_to)->first();
        if (!$approver) {
            abort(404, 'Approver not found.');
        }

        // Cari current approval berdasarkan approver sekarang
        $currentApproval = RsApproval::where('nik', $approver->nik)->first();
        if (!$currentApproval) {
            abort(403, 'Approval information not found.');
        }

        // Cek apakah ada level berikutnya
        $nextLevel = $currentApproval->level + 1;
        $nextApproval = RsApproval::where('role', $currentApproval->role)
                                  ->where('level', $nextLevel)
                                  ->first();

        if ($nextApproval) {
            // Masih ada approval berikutnya
            $nextApprover = User::where('nik', $nextApproval->nik)->first();

            $rsMaster->update([
                'route_to' => $nextApprover ? $nextApprover->nik : null,
            ]);

            if ($nextApprover) {
                // Generate token baru untuk next approver
                $newUniqueToken = (string) Str::uuid();
                $approvalToken = Crypt::encryptString($rsMaster->rs_no . '|' . $newUniqueToken . '|approve');
                $rejectToken = Crypt::encryptString($rsMaster->rs_no . '|' . $newUniqueToken . '|reject');

                dispatch(new SendRsApprovalEmail($nextApprover, $rsMaster, $approvalToken, $rejectToken));
            }
        } else {
            // Tidak ada lagi level approval, set status DONE
            $rsMaster->update([
                'status' => 'done',
                'route_to' => null,
            ]);
        }

        return response()->view('approval.success', ['message' => 'Requisition Slip approved successfully.']);

    } catch (\Exception $e) {
        return response()->view('approval.error', ['message' => $e->getMessage()], 500);
    }
}

public function reject($token)
{
    try {
        $decrypted = Crypt::decryptString($token);
        [$rsNo, $uniqueToken, $action] = explode('|', $decrypted);

        if ($action !== 'reject') {
            abort(403, 'Invalid action.');
        }

        $rsMaster = RsMaster::where('rs_no', $rsNo)->firstOrFail();

        $rsMaster->update([
            'status' => 'rejected',
            'route_to' => null,
        ]);

        return response()->view('approval.success', ['message' => 'Requisition Slip rejected successfully.']);

    } catch (\Exception $e) {
        return response()->view('approval.error', ['message' => $e->getMessage()], 500);
    }
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
    public function show(RsApproval $RsApprovals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RsAprroval $RsApprovals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RsAprroval $RsApprovals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RsAprroval $RsApprovals)
    {
        //
    }
}
