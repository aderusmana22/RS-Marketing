<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report RS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap.min.css">
    <style>
        @media print {
            body {
                /* zoom: 0.6; */
                margin: 0px;
            }
        }

        .table {
            --bs-table-border-color: #06121e !important;
        }
    </style>
</head>

<body>
    <div id="rs-form">
        <div class="card-body">
            <!-- Header Section -->
            <div class="row form-header pb-3 mb-3">
                <div class="col-6">
                    <img src="{{ asset('assets/images/logos/logoputih.png') }}" alt="" height="80">
                </div>
                <div class="col-6 text-end">
                    {{-- <h6 class="mb-1">FORM NO.: <span id="form-no">{{ $form->rs_no ?? '---' }}</span></h6> --}}
                    <h6 class="mb-1">REVISION: <span
                            id="revision-no">{{ $form->revisions->id ?? 'No Revision' }}</span></h6>
                    <h6>DATE: <span id="revision-date">{{ $form->revisions->date ?? 'No Revision Date' }}</span></h6>
                </div>
            </div>

            <!-- Title Section -->
            <div class="text-center mb-4">
                <h4 class="mb-1">REQUISITION SLIP</h4>
                <h5 class="text-muted">SALES & MARKETING {{ strtoupper($form->category) }}</h5>
            </div>

            <!-- Customer Info Section -->
            <div class="row mb-3 align-items-start">
                <div class="col-8 col-md-8" style="float:left;">
                    <p class="mb-1"><strong>CUSTOMER NAME:</strong> <span id="customer-name"
                            class="blue-text">{{ ucfirst($form->customer->name) ?? 'No Customer' }}</span></p>
                    <p class="mb-1"><strong>ADDRESS:</strong> <span id="customer-address"
                            class="blue-text">{{ ucfirst($form->customer->address) ?? 'No Address' }}</span></p>
                </div>
                <div class="col-4 col-md-4 text-end text-md-end" style="float:right;">
                    <p class="mb-1"><strong>Account:</strong> <span id="customer-account"
                            class="blue-text">{{ $form->account ?? 'No Account' }}</span></p>
                    <p class="mb-1"><strong>Tanggal:</strong> <span id="form-date"
                            class="blue-text">{{ \Carbon\Carbon::parse($form->created_at)->format('d/m/Y') ?? 'No Date' }}</span></p>
                    <p><strong>Nomor {{ $form->category == 'Sample Product' ? 'RS' : 'SRS' }}:</strong> <span
                            id="srs" class="blue-text">{{ $form->rs_no ?? 'No SRS' }}</span></p>
                </div>
            </div>

            <!-- Table Section -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>ITEM CODE</th>
                            <th>NAMA BARANG</th>
                            <th>UNIT</th>
                            <th>QTY REQUIRED</th>
                            <th>QTY ISSUED</th>
                            <th>{!! $form->category == 'Sample Product' ? 'OBJECTIVES' : 'REMARKS<br>(Batch Code)' !!}</th>
                            <th>{{ $form->category == 'Sample Product' ? 'EST POTENTIAL' : 'REASON' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($form->rs_items) && count($form->rs_items) > 0)
                            @php
                                $totalRows = 0;
                                foreach ($form->rs_items as $items) {
                                    $itemIds = is_array($items) ? $items['item_id'] ?? [] : $items->item_id ?? [];
                                    if (!is_array($itemIds)) {
                                        $itemIds = json_decode($itemIds, true);
                                    }
                                    $totalRows += is_array($itemIds) ? count($itemIds) : 0;
                                }
                                $currentRow = 0;
                            @endphp
                            @foreach ($form->rs_items as $items)
                                @php
                                    $itemIds = is_array($items) ? $items['item_id'] ?? [] : $items->item_id ?? [];
                                    if (!is_array($itemIds)) {
                                        $itemIds = json_decode($itemIds, true);
                                    }
                                    $qtyReqs = is_array($items) ? $items['qty_req'] ?? [] : $items->qty_req ?? [];
                                    if (!is_array($qtyReqs)) {
                                        $qtyReqs = json_decode($qtyReqs, true);
                                    }
                                    $qtyIssued = is_array($items)
                                        ? $items['qty_issued'] ?? []
                                        : $items->qty_issued ?? [];
                                    if (!is_array($qtyIssued)) {
                                        $qtyIssued = json_decode($qtyIssued, true);
                                    }
                                    $itemDetails = is_array($items)
                                        ? $items['item_detail'] ?? []
                                        : $items->item_detail ?? [];
                                @endphp
                                @foreach ($itemIds as $idx => $itemId)
                                    @php
                                        $detail = $itemDetails[$idx] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="blue-text">{{ $detail->item_detail_code ?? '-' }}</td>
                                        <td>{{ $detail->item_detail_name ?? '-' }}</td>
                                        <td class="text-center">{{ $detail->unit ?? '-' }}</td>
                                        <td class="text-end">{{ $qtyReqs[$idx] ?? '-' }}</td>
                                        <td class="text-end">{{ $qtyIssued[$idx] ?? '-' }}</td>
                                        @if ($currentRow == 0)
                                            @if ($form->category == 'Sample Product')
                                                <td rowspan="{{ $totalRows }}" class="blue-text">
                                                    {{ $form->objectives ?? '-' }}</td>
                                                <td rowspan="{{ $totalRows }}" class="blue-text">
                                                    {{ $form->est_potential ?? '-' }}</td>
                                            @else
                                                <td rowspan="{{ $totalRows }}" class="blue-text text-wrap text-center">
                                                    {{ is_array($items) ? $items['remarks'] ?? '-' : $items->remarks ?? '-' }}
                                                </td>
                                                <td rowspan="{{ $totalRows }}" class="blue-text text-wrap text-center">
                                                    {{ is_array($items) ? $items['reason'] ?? '-' : $items->reason ?? '-' }}
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                    @php $currentRow++; @endphp
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No Items</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>

</html>
