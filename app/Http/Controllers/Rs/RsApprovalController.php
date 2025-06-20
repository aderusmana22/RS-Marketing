<?php

namespace App\Http\Controllers\Rs;

use App\Models\RS\RSMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\sendFinalNotification;
use App\Jobs\SendRsApprovalEmail;
use App\Jobs\SendRsApprovalUpdateNotification;
use App\Mail\RsApprovalMail;
use App\Models\Approver;
use App\Models\Item\Itemdetail;
use App\Models\RS\RSItem;
use App\Models\RsApproval;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RsApprovalController extends Controller
{

    public function index()
    {
        // Replace 'auth()->user()->nik' with your actual way to get the current user's NIK
        $currentUserNik = auth()->user()->nik ?? null;

        $pendingApprovals = collect(); // Initialize as an empty collection
        if ($currentUserNik) {
            $pendingApprovals = RSMaster::where('route_to', $currentUserNik)
                                       ->where('status', 'pending')
                                       ->get();
        }

        // This view is for an approver's dashboard to see pending items
        return view('approval.index', compact('pendingApprovals'));
    }


    public function approvedNoReview(Request $request, int $rs_master_id, string $approver_nik, string $token)
    {
        // Validate and retrieve RS Master based on token and URL parameters.
        // Expects an 'approve' action within the token.
        $validationResult = $this->validateAndRetrieveRsMaster($token, $rs_master_id, $approver_nik, 'approve');
        if (is_null($validationResult)) {
            return redirect('/'); // Redirect on validation failure (Alert message is set by helper)
        }

        $rsMaster = $validationResult['rsMaster'];

        try {
            // Process the approval workflow with 'approved_no_review' status and no comment.
            $this->processApprovalWorkflow($rsMaster, $approver_nik, 'approved_no_review', null);

            Alert::success('Success', 'Requisition Slip ' . $rsMaster->rs_no . ' has been Approved (No Review) successfully!');
            return redirect('/')->with('success', 'Requisition Slip ' . $rsMaster->rs_no . ' has been Approved (No Review) successfully.');

        } catch (\Exception $e) {
            Log::error('Error processing approvedNoReview for RS ' . $rsMaster->rs_no . ': ' . $e->getMessage(), ['exception' => $e]);
            Alert::error('Error', 'An error occurred while processing your approval: ' . $e->getMessage());
            return redirect('/')->withErrors('An error occurred while processing your approval.');
        }
    }

    public function approvedWithReview(Request $request, int $rs_master_id, string $approver_nik, string $token)
    {
        // Validate and retrieve RS Master based on token and URL parameters.
        // Expects an 'approve' action within the token.
        $validationResult = $this->validateAndRetrieveRsMaster($token, $rs_master_id, $approver_nik, 'approve');
        if (is_null($validationResult)) {
            return redirect('/');
        }

        $rsMaster = $validationResult['rsMaster'];

        // If 'comment' is not present in the request (initial GET request or invalid POST submission),
        // display the comment input form.
        if (!$request->has('comment')) {
            // Ensure $rsMaster->date is a Carbon object for the view if not already cast by model.
            if (!($rsMaster->date instanceof Carbon)) {
                $rsMaster->date = Carbon::parse($rsMaster->date);
            }
            // Ensure customer relationship is loaded for the view if its name is needed.
            $rsMaster->load('customer');

            // This will return the view at resources/views/mail/commentEmail.blade.php.
            return view('mail.commentEmail', [
                'rsMaster' => $rsMaster,
                'approver_nik' => $approver_nik,
                'token' => $token,
                'action_route' => route('rs.approved-with-review', ['rs_master_id' => $rs_master_id, 'approver_nik' => $approver_nik, 'token' => $token]),
                'action_type' => 'Approve with Review',
            ]);
        }

        // If 'comment' is present in the request (form submission), validate it.
        $request->validate([
            'comment' => 'required|string|max:500' // Comment is mandatory.
        ], [
            'comment.required' => 'Please provide a comment for "Approve with Review".',
        ]);

        try {
            $comment = $request->input('comment');
            // Process the approval workflow with 'approved_with_review' status and the provided comment.
            $this->processApprovalWorkflow($rsMaster, $approver_nik, 'approved_with_review', $comment);

            Alert::success('Success', 'Requisition Slip ' . $rsMaster->rs_no . ' has been Approved (With Review) successfully!');
            return redirect('/')->with('success', 'Requisition Slip ' . $rsMaster->rs_no . ' has been Approved (With Review) successfully.');

        } catch (\Exception $e) {
            Log::error('Error processing approvedWithReview for RS ' . $rsMaster->rs_no . ': ' . $e->getMessage(), ['exception' => $e]);
            Alert::error('Error', 'An error occurred while processing your approval: ' . $e->getMessage());
            // Redirect back to the comment form with old input if an error occurs during processing.
            return redirect()->back()->withInput();
        }
    }

    public function notApproved(Request $request, int $rs_master_id, string $approver_nik, string $token)
    {
        // Validate and retrieve RS Master based on token and URL parameters.
        // Expects a 'reject' action within the token.
        $validationResult = $this->validateAndRetrieveRsMaster($token, $rs_master_id, $approver_nik, 'reject');
        if (is_null($validationResult)) {
            return redirect('/');
        }

        $rsMaster = $validationResult['rsMaster'];

        // If 'comment' is not present in the request, display the comment input form.
        if (!$request->has('comment')) {
            // Ensure $rsMaster->date is a Carbon object for the view if not already cast by model.
            if (!($rsMaster->date instanceof Carbon)) {
                $rsMaster->date = Carbon::parse($rsMaster->date);
            }
            // Ensure customer relationship is loaded for the view.
            $rsMaster->load('customer');

            // This will return the view at resources/views/mail/commentEmail.blade.php.
            return view('mail.commentEmail', [
                'rsMaster' => $rsMaster,
                'approver_nik' => $approver_nik,
                'token' => $token,
                'action_route' => route('rs.not-approved', ['rs_master_id' => $rs_master_id, 'approver_nik' => $approver_nik, 'token' => $token]),
                'action_type' => 'Not Approve',
            ]);
        }

        // If 'comment' is present in the request, validate it.
        $request->validate([
            'comment' => 'required|string|max:500' // Comment is mandatory.
        ], [
            'comment.required' => 'Please provide a comment for "Not Approve".',
        ]);

        try {
            $comment = $request->input('comment');
            // Process the rejection workflow with 'not_approved' status and the provided comment.
            $this->processApprovalWorkflow($rsMaster, $approver_nik, 'not_approved', $comment);

            Alert::success('Success', 'Requisition Slip ' . $rsMaster->rs_no . ' has been Not Approved.');
            return redirect('/')->with('success', 'Requisition Slip ' . $rsMaster->rs_no . ' has been Not Approved.');

        } catch (\Exception $e) {
            Log::error('Error processing notApproved for RS ' . $rsMaster->rs_no . ': ' . $e->getMessage(), ['exception' => $e]);
            Alert::error('Error', 'An error occurred while processing your request: ' . $e->getMessage());
            // Redirect back to the comment form with old input if an error occurs during processing.
            return redirect()->back()->withInput();
        }
    }

    protected function validateAndRetrieveRsMaster(string $token, int $rs_master_id, string $approver_nik, string $expectedTokenAction): ?array
    {
        try {
            $decrypted = Crypt::decryptString($token);
            // The token structure is "rs_no|uniqueToken|action"
            list($rsNo, $uniqueToken, $tokenAction) = explode('|', $decrypted);

            // Verify the action encoded in the token matches the expected action for this route.
            if ($tokenAction !== $expectedTokenAction) {
                 Alert::error('Error', 'Invalid link action. This link is for a different purpose or has expired.');
                 Log::warning('Token action mismatch', ['expected' => $expectedTokenAction, 'actual' => $tokenAction, 'rs_master_id' => $rs_master_id, 'approver_nik' => $approver_nik]);
                 return null;
            }

            $rsMaster = RSMaster::find($rs_master_id);
            if (!$rsMaster) {
                Alert::error('Error', 'Requisition Slip not found. It may have been deleted or archived.');
                return null;
            }

            // Ensure this link is for the currently assigned approver for this RS.
            if ($rsMaster->route_to !== $approver_nik) {
                Alert::warning('Warning', 'This approval link is not for you, or the requisition slip has already been forwarded.');
                return null;
            }

            // Ensure the RS is still in a 'pending' state.
            if ($rsMaster->status !== 'pending') {
                Alert::info('Info', 'This Requisition Slip has already been ' . $rsMaster->status . '. No further action is required.');
                return null;
            }

            return ['rsMaster' => $rsMaster, 'tokenAction' => $tokenAction];

        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Log::error('Invalid or expired token for RS approval: ' . $e->getMessage(), ['exception' => $e]);
            Alert::error('Error', 'Invalid or expired approval link. Please contact support.');
            return null;
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred during validation of RS ' . $rs_master_id . ': ' . $e->getMessage(), ['exception' => $e]);
            Alert::error('Error', 'An unexpected error occurred during validation. Please try again.');
            return null;
        }
    }

    protected function processApprovalWorkflow(RSMaster $rsMaster, string $currentApproverNik, string $newStatus, ?string $comment): void
    {
        $currentApproverUser = User::where('nik', $currentApproverNik)->first();
        if (!$currentApproverUser) {
            Log::error("Current approver user (NIK: {$currentApproverNik}) not found for workflow advancement.");
            throw new \Exception("Current approver user not found.");
        }

        // --- NEW: Find and update the current RsApproval record ---
        // Find the specific RsApproval record that was awaiting approval from this user.
        // Assuming 'token' is unique for each step or 'rs_no' + 'nik' + 'status:pending' identifies it.
        $currentRsApprovalRecord = RsApproval::where('rs_no', $rsMaster->rs_no)
                                            ->where('nik', $currentApproverNik)
                                            ->where('status', 'pending')
                                            ->first();

        if (!$currentRsApprovalRecord) {
            Log::warning('No pending RsApproval record found for RS: ' . $rsMaster->rs_no . ' and NIK: ' . $currentApproverNik . '. Possible duplicate action or out-of-sync record.');
            // This might happen if someone clicks the link twice or an old link.
            // You might want to throw an exception or just return, depending on desired strictness.
            // For now, it will proceed but won't update a specific RsApproval record.
        } else {
            $currentRsApprovalRecord->update([
                'status' => $newStatus, // Update this specific approval step's status
                // 'comment' => $comment, // You could add comment to RsApproval record if it also has a comment field
            ]);
            Log::info('RsApproval record updated for ' . $rsMaster->rs_no . ' by ' . $currentApproverNik . ' to status: ' . $newStatus);
        }
        // --- END NEW ---


        // Update the current RS Master with the last action details.
        $rsMaster->update([
            'last_approved_by_nik' => $currentApproverNik,
            'last_approved_at' => now(),
            'comment' => $comment,
            'status' => $newStatus, // This status reflects the immediate action taken (e.g., 'approved_with_review')
        ]);

        if ($newStatus === 'not_approved') {
            $rsMaster->update([
                'status' => 'rejected', // Final workflow status.
                'route_to' => null,     // No more routing needed after rejection.
            ]);
            Log::info('Requisition Slip ' . $rsMaster->rs_no . ' was rejected by ' . $currentApproverUser->name . ' (NIK: ' . $currentApproverNik . ')', ['comment' => $comment]);

            $initiator = User::where('nik', $rsMaster->initiator_nik)->first();
            $adminRsUsers = User::role('admin-rs')->get();

            if ($initiator) {
                dispatch(new SendFinalNotification(
                    $initiator,
                    $rsMaster,
                    'rejected',
                    $comment,
                    $currentApproverUser
                ));
                Log::info('Final rejection notification job dispatched to initiator: ' . $initiator->email . ' for RS: ' . $rsMaster->rs_no);
            }

            foreach ($adminRsUsers as $adminUser) {
                dispatch(new SendFinalNotification(
                    $adminUser,
                    $rsMaster,
                    'rejected',
                    $comment,
                    $currentApproverUser
                ));
                Log::info('Final rejection notification job dispatched to admin-rs: ' . $adminUser->email . ' for RS: ' . $rsMaster->rs_no);
            }

        } else { // 'approved_no_review' or 'approved_with_review'
            $currentApproverRole = $currentApproverUser->getRoleNames()->first();
            if (!$currentApproverRole) {
                 Log::error("Current approver user (NIK: {$currentApproverNik}) has no role defined for approval hierarchy.");
                 $rsMaster->update(['status' => 'error_role_missing', 'route_to' => null]);
                 throw new \Exception("Approver role not defined.");
            }

            $currentApprovalSetup = Approver::where('nik', $currentApproverNik)
                                            ->where('role', $currentApproverRole)
                                            ->first();

            $nextApprovalSetup = null;
            if ($currentApprovalSetup) {
                $nextLevel = $currentApprovalSetup->level + 1;
                $nextApprovalSetup = Approver::where('role', $currentApproverRole)
                                             ->where('level', $nextLevel)
                                             ->first();
            }

            if ($nextApprovalSetup) {
                $nextApproverUser = User::where('nik', $nextApprovalSetup->nik)->first();

                if ($nextApproverUser) {
                    $rsMaster->update([
                        'route_to' => $nextApproverUser->nik,
                        'status' => 'pending',
                    ]);
                    Log::info('Requisition Slip ' . $rsMaster->rs_no . ' routed to next approver: ' . $nextApproverUser->email);

                    $rsItemRecord = RSItem::where('rs_id', $rsMaster->id)->first();
                    $rsItemsForEmail = collect();
                    if ($rsItemRecord && is_array($rsItemRecord->item_id) && count($rsItemRecord->item_id) > 0) {
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
                    } else {
                        Log::warning('No RSItem record found for RSMaster ID: ' . $rsMaster->id . ' when preparing email for next approver.');
                    }
                    $rsMaster->load('customer');

                    $newUniqueToken = (string) Str::uuid();
                    $approvalToken = Crypt::encryptString($rsMaster->rs_no . '|' . $newUniqueToken . '|approve');
                    $rejectToken = Crypt::encryptString($rsMaster->rs_no . '|' . $newUniqueToken . '|reject');

                    $approvalNotReviewLink = route('rs.approved-no-review', [
                        'rs_master_id' => $rsMaster->id,
                        'approver_nik' => $nextApproverUser->nik,
                        'token' => $approvalToken
                    ]);
                    $approvalWithReviewLink = route('rs.approved-with-review', [
                        'rs_master_id' => $rsMaster->id,
                        'approver_nik' => $nextApproverUser->nik,
                        'token' => $approvalToken
                    ]);
                    $notApproveLink = route('rs.not-approved', [
                        'rs_master_id' => $rsMaster->id,
                        'approver_nik' => $nextApproverUser->nik,
                        'token' => $rejectToken
                    ]);

                    dispatch(new SendRsApprovalEmail(
                        $nextApproverUser,
                        $rsMaster,
                        $rsItemsForEmail,
                        $approvalToken,
                        $rejectToken,
                        $approvalNotReviewLink,
                        $approvalWithReviewLink,
                        $notApproveLink
                    ));
                    Log::info('Email dispatched to next approver for RS: ' . $rsMaster->rs_no . ' (' . $nextApproverUser->email . ')');

                    // --- NEW: Create RsApproval record for the NEXT approver ---
                    RsApproval::create([
                        'rs_no' => $rsMaster->rs_no,
                        'nik' => $nextApproverUser->nik,
                        'level' => $nextLevel,
                        'status' => 'pending',
                        'token' => $approvalToken, // Token for the next approval step
                    ]);
                    Log::info('RsApproval record created for next approver: ' . $nextApproverUser->nik . ' Level: ' . $nextLevel);
                    // --- END NEW ---


                    // --- NOTIFICATION: Intermediate Approval ---
                    $initiator = User::where('nik', $rsMaster->initiator_nik)->first();
                    if ($initiator) {
                        dispatch(new SendRsApprovalUpdateNotification(
                            $rsMaster,
                            $initiator,
                            $currentApproverUser,
                            $newStatus
                        ));
                        Log::info('Intermediate approval notification job dispatched to initiator ' . $initiator->email . ' for RS: ' . $rsMaster->rs_no);
                    }
                    // --- END NOTIFICATION ---

                } else {
                    Log::error("Next approver user (NIK: {$nextApprovalSetup->nik}) not found in User table for RS: " . $rsMaster->rs_no . ". Ending workflow.");
                    $rsMaster->update([
                        'status' => 'approved',
                        'route_to' => null,
                    ]);
                }
            } else {
                Log::info('No more approval levels defined for RS ' . $rsMaster->rs_no . ' (Role: ' . $currentApproverRole . '). Final approval reached.');
                $rsMaster->update([
                    'status' => 'approved',
                    'route_to' => null,
                ]);

                $initiator = User::where('nik', $rsMaster->initiator_nik)->first();
                $adminRsUsers = User::role('admin-rs')->get();

                if ($initiator) {
                    dispatch(new SendFinalNotification(
                        $initiator,
                        $rsMaster,
                        'approved',
                        $comment,
                        $currentApproverUser
                    ));
                    Log::info('Final approval notification job dispatched to initiator: ' . $initiator->email . ' for RS: ' . $rsMaster->rs_no);
                }

                foreach ($adminRsUsers as $adminUser) {
                    dispatch(new SendFinalNotification(
                        $adminUser,
                        $rsMaster,
                        'approved',
                        $comment,
                        $currentApproverUser
                    ));
                    Log::info('Final approval notification job dispatched to admin-rs: ' . $adminUser->email . ' for RS: ' . $rsMaster->rs_no);
                }
            }
        }
        $rsMaster->save();
    }
}
