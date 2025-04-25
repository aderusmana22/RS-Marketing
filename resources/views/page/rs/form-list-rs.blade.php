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
                        <h6 class="mb-1">FORM NO.: <span id="form-no" class="blue-text"></span></h6>
                        <h6 class="mb-1">REVISION: <span id="revision_id" class="blue-text"></span></h6>
                        <h6>DATE: <span id="form-date" class="blue-text"></span></h6>
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
                        <p class="mb-1"><strong>CUSTOMER NAME:<span id="customer_id" class="blue-text"></span></span></p>
                        <p class="mb-1"><strong>ADDRESS:<span id="address" class="blue-text"></span></p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <p class="mb-1"><strong>Account:<span id="account" class="blue-text"></span></p>
                        <p class="mb-1"><strong>Tanggal:<span id="date" class="blue-text"></span></p>
                        <p><strong>Nomor SRS:<span id="rs_no" class="blue-text"></span></p>
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
                            @foreach
                            <tr>
                                <td class="blue-text">145-172</td>
                                <td>CTN MC BM 15kg</td>
                                <td>15 kg</td>
                                <td>5</td>
                                <td></td>
                                <td rowspan="7" class="blue-text">Penggantian<br>Karton Basah</td>
                                <td class="blue-text">09 SEP 25 2437 M1</td>
                            </tr>
                            <tr>
                                <td class="blue-text">145-172</td>
                                <td>CTN MC BM 15kg</td>
                                <td>15 kg</td>
                                <td>20</td>
                                <td></td>
                                <td class="blue-text">11 SEP 25 2437 M1</td>
                            </tr>
                            <tr>
                                <td class="blue-text">145-172</td>
                                <td>CTN MC BM 15kg</td>
                                <td>15 kg</td>
                                <td>68</td>
                                <td></td>
                                <td class="blue-text">16 SEP 25 2438 M1</td>
                            </tr>
                            <tr>
                                <td class="blue-text">145-172</td>
                                <td>CTN MC BM 15kg</td>
                                <td>15 kg</td>
                                <td>36</td>
                                <td></td>
                                <td class="blue-text">20 SEP 25 2438 M1</td>
                            </tr>
                            <tr>
                                <td class="blue-text">145-167</td>
                                <td>CTN GB BOS 15kg</td>
                                <td>15 kg</td>
                                <td>10</td>
                                <td></td>
                                <td class="blue-text">15 SEP 25 2437 M1</td>
                            </tr>
                            <tr>
                                <td class="blue-text">145-048</td>
                                <td>CTN GB Flake PS 15kg</td>
                                <td>15 kg</td>
                                <td>3</td>
                                <td></td>
                                <td class="blue-text">18 JUL 25 2429 M1</td>
                            </tr>
                            <tr>
                                <td class="blue-text">136-024</td>
                                <td>Plastic bag 15kg</td>
                                <td>15 kg</td>
                                <td>142</td>
                                <td></td>
                                <td>-</td>
                            </tr>
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