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
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class RsApprovalController extends Controller
{

    public function index()
    {
        $currentUserNik = auth()->user()->nik ?? null;
        $pendingApprovals = collect();
        if ($currentUserNik) {
            $pendingApprovals = RSMaster::where('route_to', $currentUserNik)
                ->where('status', 'pending')
                ->get();
        }
        return view('approval.index', compact('pendingApprovals'));
    }

    public function approvedNoReview(Request $request, int $rs_master_id, string $approver_nik, string $token)
    {
        try {
            $decrypted = Crypt::decryptString($token);
            [$rsNo, $uniqueTokenFromToken, $actionFromToken] = explode('|', $decrypted);

            $rsMaster = RSMaster::where('rs_no', $rsNo)->firstOrFail();

            $approvalStatus = RsApproval::where('rs_no', $rsMaster->rs_no)
                ->where('nik', $approver_nik)
                ->value('status');

            if ($approvalStatus !== 'pending') {
                $message = 'This Requisition Slip has already been ' . str_replace('_', ' ', $approvalStatus) . '.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            $currentRsApprovalRecord = RsApproval::where('rs_no', $rsMaster->rs_no)
                ->where('nik', $approver_nik)
                ->where('status', 'pending')
                ->first();

            if (!$currentRsApprovalRecord || $uniqueTokenFromToken !== $currentRsApprovalRecord->token) {
                $message = 'Invalid or expired token. Please check another email.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            if ($actionFromToken !== 'approve') {
                $message = 'Invalid link action. This link is for a different purpose.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            $this->processApprovalWorkflow($rsMaster, $approver_nik, 'approved_no_review', null, $currentRsApprovalRecord);

            $successMessage = 'Requisition Slip ' . $rsMaster->rs_no . ' has been approved without review.';
            return redirect()->route('rs.success', [
                'rs_no' => $rsMaster->rs_no,
                'message' => $successMessage
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $message = 'Requisition Slip not found for this request.';
            return view('page.rs.success', compact('message'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            $message = 'Requisition Slip token has expired or is invalid. Please check another email or contact support.';
            return view('page.rs.success', compact('message'));
        } catch (\Exception $e) {
            Log::error('Error in approvedNoReview for RS ' . ($rsMaster->rs_no ?? 'N/A') . ': ' . $e->getMessage(), ['exception' => $e]);
            $message = 'An unexpected error occurred: ' . $e->getMessage();
            return view('page.rs.success', compact('message'));
        }
    }

    public function approvedWithReview(Request $request, int $rs_master_id, string $approver_nik, string $token)
    {
        try {
            $decrypted = Crypt::decryptString($token);
            [$rsNo, $uniqueTokenFromToken, $actionFromToken] = explode('|', $decrypted);

            $rsMaster = RSMaster::where('rs_no', $rsNo)->firstOrFail();

            $approvalStatus = RsApproval::where('rs_no', $rsMaster->rs_no)
                ->where('nik', $approver_nik)
                ->value('status');

            if ($approvalStatus !== 'pending') {
                $message = 'This Requisition Slip has already been ' . str_replace('_', ' ', $approvalStatus) . '.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            $currentRsApprovalRecord = RsApproval::where('rs_no', $rsMaster->rs_no)
                ->where('nik', $approver_nik)
                ->where('status', 'pending')
                ->first();

            if (!$currentRsApprovalRecord || $uniqueTokenFromToken !== $currentRsApprovalRecord->token) {
                $message = 'Invalid or expired token. Please check another email.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            if ($actionFromToken !== 'approve') {
                $message = 'Invalid link action. This link is for a different purpose.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            // Tampilkan form comment jika GET
            if (!$request->has('comment')) {
                if (!($rsMaster->date instanceof Carbon)) {
                    $rsMaster->date = Carbon::parse($rsMaster->date);
                }
                $rsMaster->load('customer');

                return view('mail.commentEmail', [
                    'rsMaster' => $rsMaster,
                    'approver_nik' => $approver_nik,
                    'token' => $token,
                    'action_route' => route('rs.approved-with-review', [
                        'rs_master_id' => $rs_master_id,
                        'approver_nik' => $approver_nik,
                        'token' => $token
                    ]),
                    'action_type' => 'Approve with Review',
                ]);
            }

            // Proses jika POST
            $request->validate([
                'comment' => 'required|string|max:500'
            ], [
                'comment.required' => 'Please provide a comment for "Approve with Review".',
            ]);

            $comment = $request->input('comment');
            $this->processApprovalWorkflow($rsMaster, $approver_nik, 'approved_with_review', $comment, $currentRsApprovalRecord);

            $successMessage = 'Requisition Slip ' . $rsMaster->rs_no . ' has been approved with review.';
            return redirect()->route('rs.success', [
                'rs_no' => $rsMaster->rs_no,
                'message' => $successMessage
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $message = 'Requisition Slip not found for this request.';
            return view('page.rs.success', compact('message'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            $message = 'Requisition Slip token has expired or is invalid. Please check another email or contact support.';
            return view('page.rs.success', compact('message'));
        } catch (\Exception $e) {
            Log::error('Error in approvedWithReview for RS ' . ($rsMaster->rs_no ?? 'N/A') . ': ' . $e->getMessage(), ['exception' => $e]);
            $message = 'An unexpected error occurred: ' . $e->getMessage();
            return view('page.rs.success', compact('message'));
        }
    }

    public function notApproved(Request $request, int $rs_master_id, string $approver_nik, string $token)
    {
        try {
            $decrypted = Crypt::decryptString($token);
            [$rsNo, $uniqueTokenFromToken, $actionFromToken] = explode('|', $decrypted);

            $rsMaster = RSMaster::where('rs_no', $rsNo)->firstOrFail();

            $approvalStatus = RsApproval::where('rs_no', $rsMaster->rs_no)
                ->where('nik', $approver_nik)
                ->value('status');

            if ($approvalStatus !== 'pending') {
                $message = 'This Requisition Slip has already been ' . str_replace('_', ' ', $approvalStatus) . '.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            $currentRsApprovalRecord = RsApproval::where('rs_no', $rsMaster->rs_no)
                ->where('nik', $approver_nik)
                ->where('status', 'pending')
                ->first();

            if (!$currentRsApprovalRecord || $uniqueTokenFromToken !== $currentRsApprovalRecord->token) {
                $message = 'Invalid or expired token. Please check another email.';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            if ($actionFromToken !== 'reject') {
                $message = 'Invalid link action. This link is for a different purpose (expected rejection).';
                return view('page.rs.success', compact('message', 'rsMaster'));
            }

            // Tampilkan form comment jika GET
            if ($request->isMethod('get')) {
                if (!($rsMaster->date instanceof Carbon)) {
                    $rsMaster->date = Carbon::parse($rsMaster->date);
                }
                $rsMaster->load('customer');

                return view('mail.commentEmail', [
                    'rsMaster' => $rsMaster,
                    'approver_nik' => $approver_nik,
                    'token' => $token,
                    'action_route' => route('rs.not-approved', [
                        'rs_master_id' => $rs_master_id,
                        'approver_nik' => $approver_nik,
                        'token' => $token
                    ]),
                    'action_type' => 'Not Approve',
                ]);
            }

            // Proses jika POST
            $request->validate([
                'comment' => 'required|string|max:500'
            ], [
                'comment.required' => 'Please provide a comment for "Not Approve".',
            ]);

            $comment = $request->input('comment');
            $this->processApprovalWorkflow($rsMaster, $approver_nik, 'not_approved', $comment, $currentRsApprovalRecord);

            $successMessage = 'Requisition Slip ' . $rsMaster->rs_no . ' has been Not Approved.';
            return redirect()->route('rs.success', [
                'rs_no' => $rsMaster->rs_no,
                'message' => $successMessage
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $message = 'Requisition Slip not found for this request.';
            return view('page.rs.success', compact('message'));
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            $message = 'Requisition Slip token has expired or is invalid. Please check another email or contact support.';
            return view('page.rs.success', compact('message'));
        } catch (\Exception $e) {
            Log::error('Error in notApproved for RS ' . ($rsMaster->rs_no ?? 'N/A') . ': ' . $e->getMessage(), ['exception' => $e]);
            $message = 'An unexpected error occurred: ' . $e->getMessage();
            return view('page.rs.success', compact('message'));
        }
    }


    protected function validateAndRetrieveRsMaster(string $token, int $rs_master_id, string $approver_nik, string $expectedTokenAction): ?array
    {
        // This helper's main purpose now is to catch decryption errors,
        // as other specific validations are moved to the individual approval methods.
        try {
            $decrypted = Crypt::decryptString($token);
            [$rsNo, $uniqueToken, $tokenAction] = explode(']', $decrypted);

            // Fetch RSMaster here, but specific validation (pending status, correct approver etc.)
            // will be done in the calling approvedNoReview/approvedWithReview/notApproved methods.
            $rsMaster = RSMaster::find($rs_master_id);
            if (!$rsMaster) {
                // Return null if RS Master is not found. The calling method will handle the message.
                return null;
            }

            return ['rsMaster' => $rsMaster, 'tokenAction' => $tokenAction];
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Re-throw or handle as needed, the calling method catches this.
            throw $e; // Re-throw to be caught by the outer try-catch block
        } catch (\Exception $e) {
            // Re-throw for generic unexpected errors.
            throw $e; // Re-throw to be caught by the outer try-catch block
        }
    }

    protected function processApprovalWorkflow(RSMaster $rsMaster, string $currentApproverNik, string $newStatus, ?string $comment, ?RsApproval $currentRsApprovalRecord): void
    {
        $currentApproverUser = User::where('nik', $currentApproverNik)->first();
        if (!$currentApproverUser) {
            Log::error("Pemberi persetujuan saat ini (NIK: {$currentApproverNik}) tidak ditemukan untuk kemajuan alur kerja.");
            throw new \Exception("Pemberi persetujuan saat ini tidak ditemukan.");
        }

        // Perbarui catatan RsApproval saat ini (atur tokennya menjadi null).
        if ($currentRsApprovalRecord) {
            $currentRsApprovalRecord->update([
                'status' => $newStatus, // Perbarui status langkah persetujuan spesifik ini
                'token' => null,        // Nullkan token untuk langkah spesifik ini
            ]);
            Log::info('Catatan RsApproval diperbarui dan token dinullkan untuk ' . $rsMaster->rs_no . ' oleh ' . $currentApproverNik . ' ke status: ' . $newStatus);
        } else {
            Log::warning('Tidak ada catatan RsApproval yang diberikan ke processApprovalWorkflow untuk menullkan token untuk RS: ' . $rsMaster->rs_no . ' oleh NIK: ' . $currentApproverNik);
        }

        // Perbarui RS Master utama dengan detail tindakan terakhir.
        $rsMaster->update([
            'last_approved_by_nik' => $currentApproverNik,
            'last_approved_at' => now(),
            'comment' => $comment,
            'status' => $newStatus, // Status ini mencerminkan tindakan segera yang diambil (misalnya, 'approved_with_review')
        ]);

        if ($newStatus === 'not_approved') {
            $rsMaster->update([
                'status' => 'rejected', // Status alur kerja final.
                'route_to' => null,     // Tidak ada lagi perutean yang diperlukan setelah penolakan.
            ]);
            Log::info('Requisition Slip ' . $rsMaster->rs_no . ' ditolak oleh ' . $currentApproverUser->name . ' (NIK: ' . $currentApproverNik . ')', ['comment' => $comment]);

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
                Log::info('Job notifikasi penolakan final dikirimkan ke inisiator: ' . $initiator->email . ' untuk RS: ' . $rsMaster->rs_no);
            }

            foreach ($adminRsUsers as $adminUser) {
                dispatch(new SendFinalNotification(
                    $adminUser,
                    $rsMaster,
                    'rejected',
                    $comment,
                    $currentApproverUser
                ));
                Log::info('Job notifikasi penolakan final dikirimkan ke admin-rs: ' . $adminUser->email . ' untuk RS: ' . $rsMaster->rs_no);
            }
        } else { // 'approved_no_review' atau 'approved_with_review'

            // Temukan level pemberi persetujuan saat ini dalam tabel setup 'Approver'.
            $currentApprovalSetup = RsApproval::where('nik', $currentApproverNik)
                ->first();

            $nextApprovalSetup = null;
            if ($currentApprovalSetup) {
                $nextLevel = $currentApprovalSetup->level + 1;
                $nextApprovalSetup = Approver::where('level', $nextLevel)->first();
            }

            if ($nextApprovalSetup) {
                $nextApproverUser = User::where('nik', $nextApprovalSetup->nik)->first();

                if ($nextApproverUser) {
                    $rsMaster->update([
                        'route_to' => $nextApproverUser->nik,
                        'status' => 'pending',
                    ]);
                    Log::info('Requisition Slip ' . $rsMaster->rs_no . ' dirutekan ke pemberi persetujuan berikutnya: ' . $nextApproverUser->email);

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
                        Log::warning('Tidak ada catatan RSItem ditemukan untuk ID RSMaster: ' . $rsMaster->id . ' saat menyiapkan email untuk pemberi persetujuan berikutnya.');
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
                    Log::info('Email dikirimkan ke pemberi persetujuan berikutnya untuk RS: ' . $rsMaster->rs_no . ' (' . $nextApproverUser->email . ')');

                    // Buat catatan RsApproval untuk pemberi persetujuan BERIKUTNYA
                    RsApproval::create([
                        'rs_no' => $rsMaster->rs_no,
                        'nik' => $nextApproverUser->nik,
                        'level' => $nextLevel,
                        'status' => 'pending',
                        'token' => $newUniqueToken,
                    ]);
                    Log::info('Catatan RsApproval dibuat untuk pemberi persetujuan berikutnya: ' . $nextApproverUser->nik . ' Level: ' . $nextLevel);

                    // NOTIFIKASI: Persetujuan Menengah
                    $initiator = User::where('nik', $rsMaster->initiator_nik)->first();
                    if ($initiator) {
                        dispatch(new SendRsApprovalUpdateNotification(
                            $rsMaster,
                            $initiator,
                            $currentApproverUser,
                            $newStatus
                        ));
                        Log::info('Job notifikasi persetujuan menengah dikirimkan ke inisiator ' . $initiator->email . ' untuk RS: ' . $rsMaster->rs_no);
                    }
                } else {
                    Log::error("Pemberi persetujuan berikutnya (NIK: {$nextApprovalSetup->nik}) tidak ditemukan dalam tabel Pengguna untuk RS: " . $rsMaster->rs_no . ". Mengakhiri alur kerja.");
                    $rsMaster->update([
                        'status' => 'approved', // Tetapkan ke status disetujui final karena tidak ada pengguna berikutnya yang valid.
                        'route_to' => null,
                    ]);
                }
            } else {
                // Tidak ada lagi level persetujuan yang ditentukan (menyiratkan persetujuan final).
                Log::info('Tidak ada lagi level persetujuan yang ditentukan untuk RS ' . $rsMaster->rs_no . '. Persetujuan final tercapai.');
                $rsMaster->update([
                    'status' => 'approved', // Tetapkan ke status disetujui final.
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
                    Log::info('Job notifikasi persetujuan final dikirimkan ke inisiator: ' . $initiator->email . ' untuk RS: ' . $rsMaster->rs_no);
                }

                foreach ($adminRsUsers as $adminUser) {
                    dispatch(new SendFinalNotification(
                        $adminUser,
                        $rsMaster,
                        'approved',
                        $comment,
                        $currentApproverUser
                    ));
                    Log::info('Job notifikasi persetujuan final dikirimkan ke admin-rs: ' . $adminUser->email . ' untuk RS: ' . $rsMaster->rs_no);
                }
            }
        }
        $rsMaster->save(); // Pastikan semua pembaruan final dipertahankan.
    }
}
