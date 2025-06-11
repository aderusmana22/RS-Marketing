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
            max-width: 1200px;
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
        
        .logo-circle {
            width: 40px;
            height: 40px;
            background-color: #d4aa2a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            margin-right: 10px;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #2a2a2a;
        }
        
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
        
        .signature-section {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .signature-box {
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background-color: #fafafa;
        }
        
        .signature-title {
            font-weight: bold;
            font-size: 12px;
            color: #141414;
            margin-bottom: 40px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 10px;
            padding-top: 5px;
            font-size: 11px;
            color: #000000;
        }

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
        
        .approve-no-review {
            border-color: #28a745;
        }
        
        .approve-no-review:hover,
        .approve-no-review.selected {
            background-color: #28a745;
            color: white;
            border-color: #28a745;
        }
        
        .approve-with-review {
            border-color: #ffc107;
        }
        
        .approve-with-review:hover,
        .approve-with-review.selected {
            background-color: #ffc107;
            color: white;
            border-color: #ffc107;
        }
        
        .not-approve {
            border-color: #dc3545;
        }
        
        .not-approve:hover,
        .not-approve.selected {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 15px 25px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #000000;
            text-align: center;
        }
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
            text-align: left;
            
            background-color: #fdfdfd;
            vertical-align: middle;
        }
        
        .signature-table tr:nth-child(even) td {
            background-color: #f8f9fa;
        }
        
        .signature-table tr:hover td {
            background-color: #e3f2fd;
        }
        
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .signature-section {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .product-table {
                font-size: 10px;
            }
            
            .product-table th,
            .product-table td {
                padding: 6px 4px;
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
                    <img src="{{ asset('assets\images\logos\logo.png')}}" alt="Company Logo" style="width: 25%; height: 100px; padding: 10px; ">
                    
                </div>
                <div class="form-title">REQUISITION SLIP</div>
                <div class="form-subtitle">SALES & MARKETING<br>{{ $rsMaster->category ?? 'Category Not Set'}}</div>
            </div>
            
            
            <div class="form-info">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
                    <div class="email-description">
                        <p style="margin: 0; font-size: 16px; color: #050505; line-height: 1.5;">
                            <!-- <strong>Subject:</strong> Requisition Slip - Permintaan Barang Sales & Marketing<br>
                            <strong>From:</strong> system@sinarmeadow.com<br>
                            <strong>To:</strong> warehouse@sinarmeadow.com<br> -->
                            <strong>Dear All:</strong>Form Requesition has been<br>

                        </p>
                    </div>
                    <div class="form-number">
                        <strong>FORM NO:</strong>{{ $rsMaster->rs_no }}<br>
                    </div>
                </div>
                
                
                <div class="info-grid">                     
                    <div class="info-item">
                        <div class="info-label">Customer Name</div>
                        <div class="info-value">{{ $rsMaster->customer_id }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $rsMaster->address }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tanggal</div>
                        <div class="info-value">{{ $rsMaster->date->format('d F Y') }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Cost Center</div>
                        <div class="info-value">{{ $rsMaster->cost_center }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Account</div>
                        <div class="info-value">{{ $rsMaster->account }}</div>
                    </div>
            </div>
            
            <table class="product-table">
                <thead>
                    <tr>
                        <th>PRODUCT CODE</th>
                        <th>PRODUCT NAME</th>
                        <th>UNIT</th>
                        <th>QTY REQUIRED</th>
                        <th>QTY ISSUED</th>
                        <th>OBJECTIVES</th>
                        <th>ESTIMASI POTENSI<br>(Remarks in Carton)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 600; color: #000000;">{{$rsItem->item_details->item_detail_code}}</td>
                        <td style="font-weight: 600; color: #000000;">{{$rsItem->item_details->item_detail_name}}</td>
                        <td style="font-weight: 600; color: #000000;">{{$rsItem->item_details->unit}}</td>
                        <td style="font-weight: 600; color: #000000;">{{$rsItem->qtd_issued}}</td>
                        <td style="font-weight: 600; color: #000000;">{{$rsItem->qtd_req}}</td>
                        <td style="font-weight: 600; color: #000000;">{{$rsMaster->objectives}}</td>
                        <td style="font-weight: 600; color: #000000;">{{$rsMaster->est_potential}}</td>
                    </tr>
                    
                </tbody>
            </table>
            
            <!-- approval section -->
            <div class="approval-section">
                <div class="approval-title">Approval </div>
                <div class="approval-options">
                    <button class="approval-btn approve-no-review" onclick="selectApproval(this, 'approved-no-review')">
                        <span class="btn-icon">✓</span>
                        Approved (No Review)
                    </button>
                    <button class="approval-btn approve-with-review" onclick="selectApproval(this, 'approved-with-review')">
                        <span class="btn-icon">⚠</span>
                        Approve with Review
                    </button>
                    <button class="approval-btn not-approve" onclick="selectApproval(this, 'not-approved')">
                        <span class="btn-icon">X</span>
                        Not Approve
                    </button>
                </div>
            </div>
        
        
        <div class="email-footer">
            <p><strong>Email ini dikirim secara otomatis dari sistem Requisition Management.</strong></p>
            <p>Jika ada pertanyaan, silakan hubungi tim Sales & Marketing</p>
            <p>© 2025 Sinar Meadow. All rights reserved.</p>
        </div>
    </div>
</body>
</html>