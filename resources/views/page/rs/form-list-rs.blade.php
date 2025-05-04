<x-app-layout>
@section('title')
        Requisition Slip
    @endsection

    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logo {
            max-height: 100px;
        }
        .form-header {
            border-bottom: 2px solid #c4c5c5;
        }
        .table th {
            background-color: #acadae;
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
        }
    
        .signature-section {
            border-top: 1px solid #d4d5d6;
        }
        .signature-box {
            min-height: 80px;
            border-bottom: 1px solid #cccecf;
        }
        .blue-text {
            color: rgb(14, 14, 14);
        }
    </style>
    @endpush

    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Header Section -->
                <div class="row form-header pb-3 mb-3">
                    <div class="col-6">
                        <img src="{{ asset('assets/images/logos/logoputih.png') }}"class="logo">
                    </div>
                    <div class="col-6 text-end">
                        <h6 class="mb-1">FORM NO.: <span class="blue-text">{{ $master['rs_no'] }}</span></h6>
                        <h6 class="mb-1">REVISION: <span class="blue-text">{{ $master['revision_id'] }}</span></h6>
                        <h6>DATE: <span class="blue-text">{{ $master['date'] }}</span></h6>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="text-center mb-4">
                    <h4 class="mb-1">REQUISITION SLIP</h4>
                    <h5 class="text-muted">SALES & MARKETING PACKAGING KOSONG</h5>
                </div>

                <!-- Customer Info Section -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <p class="mb-1"><strong>CUSTOMER NAME:</strong> <span class="blue-text">{{ $master['customer_name'] }}</span></p>
                        <p class="mb-1"><strong>ADDRESS:</strong> <span class="blue-text">{{ $master['address'] }}</span></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <p class="mb-1"><strong>Account:</strong> <span class="blue-text">{{ $master['account'] }}</span></p>
                        <p class="mb-1"><strong>Tanggal:</strong> <span class="blue-text">{{ $master['date'] }}</span></p>
                        <p><strong>Nomor SRS:</strong> <span class="blue-text">{{ $master[''] }}</span></p>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ITEM CODE</th>
                                <th>NAMA BARANG</th>
                                <th>UNIT</th>
                                <th>QTY REQUIRED</th>
                                <th>QTY ISSUED</th>
                                <th>Remarks<br>(Batch Code)</th>
                                <th>ALASAN PENGGANTIAN</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                            <tr>
                                <td class="blue-text">{{ $item['item_code'] }}</td>
                                <td>{{ $item['item_name'] }}</td>
                                <td>{{ $item['unit'] }}</td>
                                <td>{{ $item['qty_req'] }}</td>
                                <td>{{ $item['qty_issued'] ?? '' }}</td>
                                <td class="blue-text">{{ $item['batch_code'] ?? '-' }}</td>
                                @if($index === 0)
                                    <td class="blue-text" rowspan="{{ count($items) }}">{{ $master['reason'] }}</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>


                @push('scripts')
                <script>
                    $(document).ready(function () {
                        let rsId = {{ $rs_id ?? 'null' }};
                        if (rsId) {
                            $.ajax({
                                url: `/requisition/${rsId}`,
                                type: 'GET',
                                success: function (data) {
                                    $('#form-date').text("DATE: " + data.master.date);
                                    $('#customer-name').text(data.master.customer_name);
                                    $('#customer-address').text(data.master.customer_address);
                                    $('#account').text(data.master.customer_id);
                                    $('#tanggal').text(data.master.date);
                                    $('#rs-no').text(data.master.rs_no);
                                    $('#form-no').text(response.master.form_no);
                                    $('#revision').text(response.master.revision);
                                    $('#form-date').text(response.master.date);
                                    $('#item-code').text(data.items[0].item_code);
                                    $('#item-name').text(data.items[0].item_name);

                
                                    let reason = data.master.reason;
                
                                    let rows = '';
                                    data.items.forEach((item, index) => {
                                        rows += `<tr>
                                            <td class="blue-text">${item.item_code}</td>
                                            <td>${item.item_name}</td>
                                            <td>${item.unit}</td>
                                            <td>${item.qty_req}</td>
                                            <td>${item.qty_issued ?? ''}</td>
                                            <td class="blue-text">${item.batch_code ?? '-'}</td>
                                            ${index === 0 ? `<td class="blue-text" rowspan="${data.items.length}">${reason}</td>` : ''}
                                        </tr>`;
                                        
                                    });
                                    $('#rs-table tbody').html(rows);

        
                                }
                            
                            
                        }
                    });
                </script>
                @endpush
 
</x-app-layout>

</html>