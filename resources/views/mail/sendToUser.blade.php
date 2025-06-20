<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requisition Slip - Email Outlook</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #eaeaea;
            color: #030303;
        }

        .email-container {
            max-width: 1200px; /* Increased max-width for better layout */
            margin: 0 auto;
            background-color: rgb(242, 242, 242);
            border: 1px solid #f2f2f2;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .email-header {
            background-color: #d5ad09;
            color: rgb(0, 0, 0);
            padding: 15px 20px;
            border-bottom: 3px solid #e1c00a;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .email-body {
            padding: 25px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #d4bb00;
        }

        .company-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        /* .logo-circle, .company-name styles from previous versions removed if not used */

        .form-title {
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0 5px 0;
            color: #ddba07;
        }

        .form-subtitle {
            font-size: 14px;
            color: #070707;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .form-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #e0c40b;
        }

        .form-number {
            text-align: right;
            font-size: 15px;
            color: #090909;
            margin-bottom: 10px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: bold;
            color: #d4b800;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .info-value {
            color: #202020;
            font-size: 14px;
            padding: 8px 12px;
            background-color: #f4f4f4;
            border-radius: 4px;
            border: 1px solid #0d0d0d;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        .product-table th {
            background-color: #fddf4c;
            color: rgb(0, 0, 0);
            padding: 12px 8px;
            text-align : center;
            font-weight: 900;
            border: 1px solid #000000;
        }

        .product-table td {
            padding: 10px 8px;
            border: 1px solid #000000;
            text-align: center;
            background-color: #fdfdfd;
        }

        .product-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .product-table tr:hover td {
            background-color: #e3f2fd;
        }

        /* Signature section and table styles */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 12px;
        }

        .signature-table th {
            background-color: #dbc60e;
            color: rgb(0, 0, 0);
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #000000;
        }

        .signature-table td {
            padding: 15px 8px;
            border: 1px solid #1d1d1d;
            text-align: center; /* Changed from left to center for consistency with headers */
            background-color: #fdfdfd;
            vertical-align: middle;
        }

        .signature-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .signature-table tr:hover td {
            background-color: #e3f2fd;
        }

        /* Approval buttons section */
        .approval-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .approval-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .approval-options {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: nowrap;
            align-items: center;
        }

        .approval-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 18px;
            border: 2px solid #ddd;
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 140px;
            font-size: 12px;
            font-weight: 600;
            color: #333;
            outline: none;
            white-space: nowrap;
            text-decoration: none; /* Add this to remove underline from links */
        }

        .approval-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .approval-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-icon {
            margin-right: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .approve-no-review { border-color: #28a745; }
        .approve-no-review:hover, .approve-no-review.selected { background-color: #28a745; color: white; border-color: #28a745; }
        .approve-with-review { border-color: #ffc107; }
        .approve-with-review:hover, .approve-with-review.selected { background-color: #ffc107; color: white; border-color: #ffc107; }
        .not-approve { border-color: #dc3545; }
        .not-approve:hover, .not-approve.selected { background-color: #dc3545; color: white; border-color: #dc3545; }


        .email-footer {
            background-color: #f8f9fa;
            padding: 15px 25px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #000000;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .product-table {
                font-size: 10px;
            }
            .product-table th, .product-table td {
                padding: 6px 4px;
            }

            .signature-table { /* On small screens, signature table might stack */
                display: block; /* Allows table to scroll if too wide */
                overflow-x: auto;
                white-space: nowrap;
            }
            .approval-options {
                flex-direction: column; /* Stack buttons vertically on small screens */
                align-items: stretch;
            }
            .approval-btn {
                min-width: unset; /* Remove fixed width */
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📧 Requisition Slip</h1>
        </div>

        <div class="email-body">
            <div class="form-header">
                <div class="company-logo">
                    {{-- Use asset() only if the email client supports loading images from your server.
                         For robust email, consider embedding images (Mailable::embed) or using external public URLs. --}}
                    <img src="{{ asset('assets/images/logos/logo.png') }}" alt="Company Logo" style="width: 25%; height: 100px; padding: 10px; ">
                </div>
                <div class="form-title">REQUISITION SLIP</div>
                {{-- Dynamically display category from $rsMaster --}}
                <div class="form-subtitle">SALES & MARKETING<br>{{ $rsMaster->category ?? 'Category Not Set'}}</div>
            </div>

            <div class="form-info">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div class="email-description">
                        <p style="margin: 0; font-size: 16px; color: #050505; line-height: 1.5;">
                            <strong>Dear All:</strong> Form Requisition has been submitted for your approval.<br>
                        </p>
                    </div>
                    <div class="form-number">
                        <strong>FORM NO:</strong> {{ $rsMaster->rs_no }}<br>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Customer Name</div>
                        {{-- Access customer name via relationship --}}
                        <div class="info-value">{{ $rsMaster->customer->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $rsMaster->address ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal</div>
                        {{-- Ensure $rsMaster->date is a Carbon instance in the Mailable/Controller --}}
                        <div class="info-value">{{ \Carbon\Carbon::parse($rsMaster->date)->format('d F Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Cost Center</div>
                        <div class="info-value">{{ $rsMaster->cost_center ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Account</div>
                        <div class="info-value">{{ $rsMaster->account ?? 'N/A' }}</div>
                    </div>
                    {{-- Conditionally display fields based on category --}}
                    @if ($rsMaster->category === 'Sample Product')
                        <div class="info-item">
                            <div class="info-label">Objectives</div>
                            <div class="info-value">{{ $rsMaster->objectives ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Estimasi Potensi</div>
                            <div class="info-value">{{ $rsMaster->est_potential ?? 'N/A' }}</div>
                        </div>
                    @elseif ($rsMaster->category === 'Packaging')
                        <div class="info-item">
                            <div class="info-label">Reason</div>
                            <div class="info-value">{{ $rsMaster->reason ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Batch Code</div>
                            <div class="info-value">{{ $rsMaster->batch_code ?? 'N/A' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">RS Number</div>
                            <div class="info-value">{{ $rsMaster->rs_number ?? 'N/A' }}</div>
                        </div>
                    @endif
                </div>

                <table class="product-table">
                    <thead>
                        <tr>
                            <th>PRODUCT CODE</th>
                            <th>PRODUCT NAME</th>
                            <th>UNIT</th>
                            <th>QTY REQUIRED</th>
                            <th>QTY ISSUED</th>
                            {{-- Conditionally display Objectives/Estimasi Potensi in table header if appropriate --}}
                            @if ($rsMaster->category === 'Sample Product')
                                <th>OBJECTIVES</th>
                                <th>ESTIMASI POTENSI<br>(Remarks in Carton)</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rsItems as $item)
                            <tr>
                                <td style="font-weight: 600; color: #000000;">{{ $item->item_detail_code ?? 'N/A' }}</td>
                                <td style="font-weight: 600; color: #000000;">{{ $item->item_detail_name ?? 'N/A' }}</td>
                                <td style="font-weight: 600; color: #000000;">{{ $item->unit ?? 'N/A' }}</td>
                                <td style="font-weight: 600; color: #000000;">{{ $item->qty_req ?? '-' }}</td>
                                <td style="font-weight: 600; color: #000000;">{{ $item->qty_issued ?? '-' }}</td>
                                {{-- Objectives and Estimasi Potensi are stored at RS Master level, not per item.
                                     Display them here only if it makes sense in your business logic.
                                     If they are not per-item, these columns should likely be removed from the item table or only display the main RSMaster values once. --}}
                                @if ($rsMaster->category === 'Sample Product')
                                    <td style="font-weight: 600; color: #000000;">{{ $rsMaster->objectives ?? 'N/A' }}</td>
                                    <td style="font-weight: 600; color: #000000;">{{ $rsMaster->est_potential ?? 'N/A' }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $rsMaster->category === 'Sample Product' ? '7' : '5' }}" style="text-align: center;">No product items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            {{-- Signature Table (Approval History) --}}
            <table class="signature-table">
                <thead>
                    <tr>
                        <th>NAME/SIGNATURE</th>
                        <th>APPROVED (NO REVIEW)</th>
                        <th>APPROVED (WITH REVIEW)</th>
                        <th>NOT APPROVED</th>
                        <th>NOTES</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop through approval history records (e.g., $approvalsHistory from Mailable) --}}
                    {{-- You need to pass $approvalsHistory to the Mailable --}}
                    @forelse ($approvalsHistory as $history)
                        <tr>
                            <td style="font-weight: 600;">{{ $history->approver_user->name ?? $history->approver_nik }}</td>
                            <td style="font-weight: 600; text-align: center; color: rgb(4, 129, 25);">
                                @if ($history->status === 'approved_no_review') ✓ @endif
                            </td>
                            <td style="font-weight: 600; text-align: center; color: rgb(226, 210, 30);">
                                @if ($history->status === 'approved_with_review') ✓ @endif
                            </td>
                            <td style="font-weight: 600; text-align: center; color: rgb(244, 50, 33);">
                                @if ($history->status === 'not_approved') ✕ @endif
                            </td>
                            <td style="font-weight: 600;">{{ $history->comment ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No approval history available yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Approval Buttons Section --}}
            <div class="approval-section">
                <div class="approval-title">Approval Actions</div>
                <div class="approval-options">
                    <a href="{{ $approvalNotReviewLink }}" class="approval-btn approve-no-review">
                        <span class="btn-icon">✓</span>Approved (No Review)
                    </a>
                    <a href="{{ $approvalWithReviewLink }}" class="approval-btn approve-with-review">
                        <span class="btn-icon">⚠</span>Approve with Review
                    </a>
                    <a href="{{ $notApproveLink }}" class="approval-btn not-approve">
                        <span class="btn-icon">X</span>Not Approve
                    </a>
                </div>
            </div>

            <div class="email-footer">
                <p><strong>Email ini dikirim secara otomatis dari sistem Requisition Management.</strong></p>
                <p>Jika ada pertanyaan, silakan hubungi tim Sales & Marketing di ext. 225</p>
                <p>© 2025 Sinar Meadow. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>