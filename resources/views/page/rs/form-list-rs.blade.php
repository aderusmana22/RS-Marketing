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
                        <h6 class="mb-1">FORM NO.: <span class="blue-text">{{ $master->rs_no }}</span></h6>
                        <h6 class="mb-1">REVISION: <span class="blue-text">{{ $master->revision_id }}</span></h6>
                        <h6>DATE: <span class="blue-text">{{ $master->date }}</span></h6>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="text-center mb-4">
                    <h4 class="mb-1">REQUISITION SLIP</h4>
                    <h5 class="text-muted">
                        @if ($master->category === 'Sample Product')
                            SAMPLE PRODUCT
                        @elseif($master->category === 'Packaging')
                            PACKAGING KOSONG
                        @else
                            {{ strtoupper($master->category) }}
                        @endif
                    </h5>
                </div>

                <!-- Customer Info Section -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <p class="mb-1"><strong>CUSTOMER NAME:</strong> <span
                                class="blue-text">{{ ucfirst($master->customer->name) }}</span></p>
                        <p class="mb-1"><strong>ADDRESS:</strong> <span
                                class="blue-text">{{ ucfirst($master->customer->address) }}</span></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <p class="mb-1"><strong>Account:</strong> <span
                                class="blue-text">{{ $master->account }}</span></p>
                        <p class="mb-1"><strong>Tanggal:</strong> <span
                                class="blue-text">{{ \Carbon\Carbon::parse($master->date)->format('d-m-Y') }}</span></p>


                        @if ($master->category === 'Packaging')
                            <p><strong>Nomor RS:</strong> <span class="blue-text">{{ $master->rs_no }}</span></p>
                        @else
                            <p><strong>Nomor SRS:</strong> <span class="blue-text">{{ $master->rs_no }}</span></p>
                        @endif
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>PRODUCT CODE</th>
                                <th>PRODUCT NAME</th>
                                <th>UNIT</th>
                                <th>QTY REQUIRED</th>
                                <th>QTY ISSUED</th>
                                @if ($master->category === 'Sample Product')
                                    <th>OBJECTIVES</th>
                                    <th>ESTIMASI POTENSI</th>
                                @elseif($master->category === 'Packaging')
                                    <th>REASON</th>
                                    <th>BATCH CODE</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($master->rs_items as $rs_item)
                                @php
                                    $itemIds = is_array($rs_item->item_id)
                                        ? $rs_item->item_id
                                        : json_decode($rs_item->item_id, true);
                                    $qtyReqs = is_array($rs_item->qty_req)
                                        ? $rs_item->qty_req
                                        : json_decode($rs_item->qty_req, true);
                                    $qtyIssued = is_array($rs_item->qty_issued)
                                        ? $rs_item->qty_issued
                                        : json_decode($rs_item->qty_issued, true);
                                    $rowCount = is_array($itemIds) ? count($itemIds) : 0;
                                @endphp
                                @if (is_array($itemIds))
                                    @foreach ($itemIds as $idx => $itemId)
                                        @php
                                            $itemDetail = \App\Models\Item\Itemdetail::find($itemId);
                                        @endphp
                                        <tr>
                                            <td class="blue-text">
                                                {{ $itemDetail ? $itemDetail->item_detail_code : '-' }}</td>
                                            <td>{{ $itemDetail ? $itemDetail->item_detail_name : '-' }}</td>
                                            <td>{{ $itemDetail ? $itemDetail->unit : '-' }}</td>
                                            <td>{{ $qtyReqs[$idx] ?? '-' }}</td>
                                            <td>{{ $qtyIssued[$idx] ?? '-' }}</td>
                                            @if ($master->category === 'Sample Product')
                                                @if ($idx == 0)
                                                    <td rowspan="{{ $rowCount }}">{{ $master->objectives ?? '-' }}
                                                    </td>
                                                    <td rowspan="{{ $rowCount }}">
                                                        {{ $master->est_potential ?? '-' }}</td>
                                                @endif
                                            @elseif($master->category === 'Packaging')
                                                @if ($idx == 0)
                                                    <td rowspan="{{ $rowCount }}">{{ $master->reason ?? '-' }}
                                                    </td>
                                                    <td rowspan="{{ $rowCount }}">{{ $master->batch_code ?? '-' }}
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                let rsId = {{ $rs_id ?? 'null' }};
                if (rsId) {
                    $.ajax({
                        url: `/requisition/${rsId}`,
                        type: 'GET',
                        success: function(data) {
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
                    })

                }
            });
        </script>
    @endpush


</x-app-layout>
