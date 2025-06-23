<!DOCTYPE html>
<html>
<head>
    <title>Requisition Slip Final Status</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0; }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: {{ $finalStatus === 'approved' ? '#28a745' : '#dc3545' }};
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
            font-size: 20px;
            font-weight: bold;
        }
        .content { padding: 20px; color: #333; line-height: 1.6; }
        .detail { margin-bottom: 10px; }
        .detail strong { display: inline-block; width: 120px; font-weight: bold; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            font-size: 0.85em;
            color: #666;
            text-align: center;
        }
        .button-link {
            display: inline-block;
            background-color: #007bff;
            color: white !important; /* !important for email clients */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Requisition Slip #{{ $rsMaster->rs_no }} - {{ ucfirst($finalStatus) }}
        </div>
        <div class="content">
            <p>Dear all,</p>
            <p>Please be informed that Requisition Slip **{{ $rsMaster->rs_no }}** has reached its final status: **{{ ucfirst($finalStatus) }}**.</p>

            @if($actionBy)
                <p>The final action was performed by: **{{ $actionBy->name }} ({{ $actionBy->nik }})**</p>
            @endif

            @if($comment)
                <p><strong>Comment:</strong> "{{ $comment }}"</p>
            @endif

            <h3>Summary:</h3>
            <div class="detail"><strong>Form No:</strong> {{ $rsMaster->rs_no }}</div>
            <div class="detail"><strong>Category:</strong> {{ $rsMaster->category }}</div>
            <div class="detail"><strong>Initiator:</strong> {{ $rsMaster->initiator->name ?? $rsMaster->initiator_nik }}</div>
            <div class="detail"><strong>Customer:</strong> {{ $rsMaster->customer->name ?? 'N/A' }}</div>
            <div class="detail"><strong>Date:</strong> {{ $rsMaster->date->format('d F Y') }}</div>
            <div class="detail"><strong>Status:</strong> <span style="color: {{ $finalStatus === 'approved' ? '#28a745' : '#dc3545' }}; font-weight: bold;">{{ ucfirst($finalStatus) }}</span></div>

            {{-- You might add a link back to the system for viewing the RS --}}
            {{-- <p style="text-align: center;">
                <a href="{{ route('rs.show', $rsMaster->id) }}" class="button-link">View Requisition Slip</a>
            </p> --}}

            <p>Thank you for your attention.</p>
        </div>
        <div class="footer">
            This is an automated email from the Requisition Management System. Please do not reply to this email.
            <br>&copy; {{ date('Y') }} Sinar Meadow. All rights reserved.
        </div>
    </div>
</body>
</html>