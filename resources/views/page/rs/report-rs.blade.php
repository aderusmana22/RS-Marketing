<x-app-layout>
    @section('title')
        Report RS
    @endsection

    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap.min.css">
        <style>
            
        </style>
    @endpush


    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4 no-print">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Report Requisition Slip</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Report RS</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets') }}/images/breadcrumb/ChatBc.png" alt="modernize-img"
                            class="img-fluid mb-n4">
                    </div>
                </div>
                <div class="col-3">
                    <button onclick="history.back()" class="btn btn-sm btn-primary flex-end">Back</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card overflow-hidden invoice-application">
        <div class="d-flex align-items-center justify-content-between gap-6 m-3 d-lg-none no-print">
            <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#chat-sidebar" aria-controls="chat-sidebar">
                <i class="ti ti-menu-2 fs-5"></i>
            </button>
            <form class="position-relative w-100">
                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                    placeholder="Search RS">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
        </div>
        <div class="d-flex">
            <div class="w-25 d-none d-lg-block border-end user-chat-box no-print">
                <div class="p-3 border-bottom">
                    <form class="position-relative">
                        <input type="search" class="form-control search-invoice ps-5" id="text-srh1"
                            placeholder="Search RS1">
                        <i
                            class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="app-invoice">
                    <ul class="overflow-auto invoice-users" data-simplebar="init">
                        <div id="list-form" class="simplebar-content" style="padding: 0px;">
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                        </div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                            <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="w-75 w-xs-100 chat-container">
                <div class="invoice-inner-part h-100">
                    <div class="invoiceing-box">
                        <div class="invoice-header d-flex align-items-center border-bottom p-3 no-print">
                            <h4 class="mb-0"><span id="title-report">Project Name</span></h4>
                            <div class="ms-auto">
                                <h4 class="invoice-number">#<span id="id-report">---</span></h4>
                            </div>
                        </div>
                        <div id="rs-form">
                            <div class="card-body">
                                <!-- Header Section -->
                                <div class="row form-header pb-3 mb-3">
                                    <div class="col-6">
                                        <img src="{{ asset('assets/images/logos/logoputih.png') }}" alt="" height="80">
                                    </div>
                                    <div class="col-6 text-end">
                                        <h6 class="mb-1">FORM NO.: <span id="form-no"></span></h6>
                                        <h6 class="mb-1">REVISION: <span id="revision-no"></span></h6>
                                        <h6>DATE: <span id="revision-date"></span></h6>
                                    </div>
                                </div>

                                <!-- Title Section -->
                                <div class="text-center mb-4">
                                    <h4 class="mb-1">REQUISITION SLIP</h4>
                                    <h5 class="text-muted">SALES & MARKETING <span id="category"></span></h5>
                                </div>

                                <!-- Customer Info Section -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <p class="mb-1"><strong>CUSTOMER NAME:</strong> <span id="customer-name" class="blue-text">PT AMA</span></p>
                                        <p class="mb-1"><strong>ADDRESS:</strong> <span id="customer-address" class="blue-text">MEDAN</span></p>
                                    </div>
                                    <div class="col-md-4 text-md-end">
                                        <p class="mb-1"><strong>Account:</strong> <span id="customer-account" class="blue-text">4914</span></p>
                                        <p class="mb-1"><strong>Tanggal:</strong> <span id="form-date" class="blue-text"></span></p>
                                        <p><strong>Nomor <span id="no_rs">RS</span>:</strong> <span id="srs" class="blue-text">P 24 10 542</span></p>
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
                                                <th><span id="category1">Remarks<br>(Batch Code)</span></th>
                                                <th><span id="category2">ALASAN PENGGANTIAN</span></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
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
                            </div>    
                            <hr>
                            <div class="text-end">
                                <a id="print-form" class="btn btn-primary btn-default print-page ms-6"
                                    type="button">
                                    <span>
                                        <i class="ti ti-printer fs-5"></i>
                                        Print
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-start user-chat-box no-print" tabindex="-1" id="chat-sidebar"
                aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                        Invoice
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="p-3 border-bottom">
                    <form class="position-relative">
                        <input type="search" class="form-control search-invoice ps-5" id="text-srh2"
                            placeholder="Search RS">
                        <i
                            class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="app-invoice overflow-auto">
                    <ul id="list-form2" class="invoice-users">
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
        <script>
            var forms = "";
            // Ketika html sudah dimuat
            document.addEventListener('DOMContentLoaded', function() {
                function makeAllReadonly() {
                    // Menjadikan semua elemen input dan textarea readonly
                    var inputs = document.querySelectorAll('#rs-form input, #rs-form textarea');  // Pilih semua input
                    inputs.forEach(function(input) {
                        if (input.type === 'radio') {
                            if (!input.checked) {
                                input.disabled = true;  // Menonaktifkan radio button jika belum disabled
                            }
                        } else {
                            input.readOnly = true; // Setiap input dan textarea menjadi readonly
                        }
                    
                    });
                }
                makeAllReadonly();

                // fetch data form
                $.ajax({
                    url: '{{ route('rs.getFormList') }}', // URL ke controller
                    method: 'GET',
                    success: function(response) {
                        forms = response;
                        var listForm = '';
                        response.forEach((form, index) => {
                            listForm +=
                            `<a href="javascript:void(0)"
                                class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                onClick="changeForm(${index})">
                                <div
                                    class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                    <i class="ti ti-folder fs-6"></i>
                                </div>
                                <div class="ms-3 d-inline-block w-75">
                                    <h6 class="mb-0 invoice-customer">${form.category}</h6>
                                    <span class="fs-3 invoice-id text-truncate text-body-color d-block w-85">
                                        ${form.rs_no}
                                    </span>
                                    <span class="fs-3 invoice-date text-nowrap text-body-color d-block">
                                        ${form.new_created_at}
                                    </span>
                                </div>
                            </a>`;
                        });
                        $('#list-form').html(listForm);
                        $('#list-form2').html(listForm);
                    },
                    error: function() {
                        // Jika gagal, tampilkan pesan error
                        console.log('Error ketika mengambil data form');
                        // $('#formData').html('<p>There was an error fetching the data.</p>');
                    }
                });
            });

            // Fungsi untuk menghapus data dari tampilan form
            function clearForm(){
                $('#rs-form input[type="radio"]').prop('checked', false).prop('disabled', true);
                $('#rs-form textarea').text('');
                $('#rs-form text').val('');
            }

            // Fungsi untuk mengganti data pada tampilan form
            function changeForm(index){
                clearForm();
                var form = forms[index];
                console.log(form);

                $('#title-report').text(form.category ?? 'No Title');
                $('#id-report').text(form.rs_no ?? '---');

                $('#form-no').text(form.rs_no ?? '---');
                $('#category').text((form.category ?? 'No Category').toUpperCase());
                
                // Revision
                $('#revision-no').text(form.revisions.id ?? 'No Revision');
                $('#revision-date').text(form.revisions.date ?? 'No Revision Date');
                
                // Customer Info
                $('#customer-name').text(form.customer.name ?? 'No Customer');  
                $('#customer-address').text(form.customer.address ?? 'No Address');
                $('#customer-account').text(form.customer.account ?? 'No Account');
                $('#form-date').text(form.new_created_at ?? 'No Date');
                $('#no_rs').text(form.category === 'Sample Product' ? 'RS' : 'SRS');
                $('#srs').text(form.rs_number ?? '-');
                $('#category1').html(form.category === 'Sample Product' ? 'OBJECTIVES' : 'REMARKS<br>(Batch Code)');
                $('#category2').text(form.category === 'Sample Product' ? 'ESTIMATE POTENTIAL' : 'REASON');

                let table = $('#rs-form table tbody');
                table.empty(); // Clear existing rows
                // item details
                if (form.rs_items && form.rs_items.length > 0) {
                    form.rs_items.forEach(function(items, index) {
                        items.item_detail.forEach(function(detail, index) {
                            let row = `
                                <tr>
                                    <td class="blue-text">${detail.type}</td>
                                    <td>${detail.item_detail_code}</td>
                                    <td>${detail.net_weight} ${detail.unit}</td>
                                    <td>${items.qty_req}</td>
                                    <td>${items.qty_issued}</td>
                                    ${index === 0 ?
                                        form.category === 'Sample Product'
                                            ? `<td rowspan="${form.rs_items.length}" class="blue-text">${form.objectives ?? ''}</td>
                                               <td rowspan="${form.rs_items.length}" class="blue-text">${form.est_potential ?? ''}</td>`
                                            :
                                            `<td rowspan="${form.rs_items.length}" class="blue-text">${form.batch_code ?? ''}</td>
                                             <td rowspan="${form.rs_items.length}" class="blue-text">${form.reason ?? ''}</td>`
                                    : 
                                        ''
                                    }
                                </tr>`;
                            table.append(row);
                        })
                    });
                } else {
                    let row = `<tr><td colspan="7" class="text-center">Tidak ada item detail</td></tr>`;
                    table.append(row);
                }

                // Print Button
                $('#print-form').attr('href', "{{ route('rs.print', ['no' => '__ID__']) }}".replace('__ID__', form.rs_no));
                $('#print-form').attr('target', '_blank');
            }

            $('#text-srh1').on('input', function() {
                var value = $(this).val().toLowerCase();
                var listForm = '';
                forms.forEach((form, index) => {
                    // Cek apakah form cocok dengan filter
                    if (
                        (form.category && form.category.toLowerCase().includes(value)) ||
                        (form.rs_no && form.rs_no.toLowerCase().includes(value)) ||
                        (form.new_created_at && form.new_created_at.toLowerCase().includes(value))
                    ) {
                        listForm +=
                        `<a href="javascript:void(0)"
                            class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                            onClick="changeForm(${index})">
                            <div class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                <i class="ti ti-folder fs-6"></i>
                            </div>
                            <div class="ms-3 d-inline-block w-75">
                                <h6 class="mb-0 invoice-customer">${form.category}</h6>
                                <span class="fs-3 invoice-id text-truncate text-body-color d-block w-85">
                                    ${form.rs_no}
                                </span>
                                <span class="fs-3 invoice-date text-nowrap text-body-color d-block">
                                    ${form.new_created_at}
                                </span>
                            </div>
                        </a>`;
                    }
                });
                $('#list-form').html(listForm);
            });

            $('#text-srh2').on('input', function() {
                var value = $(this).val().toLowerCase();
                var listForm = '';
                forms.forEach((form, index) => {
                    // Cek apakah form cocok dengan filter
                    if (
                        (form.category && form.category.toLowerCase().includes(value)) ||
                        (form.rs_no && form.rs_no.toLowerCase().includes(value)) ||
                        (form.new_created_at && form.new_created_at.toLowerCase().includes(value))
                    ) {
                        listForm +=
                        `<a href="javascript:void(0)"
                            class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                            onClick="changeForm(${index})">
                            <div class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                <i class="ti ti-folder fs-6"></i>
                            </div>
                            <div class="ms-3 d-inline-block w-75">
                                <h6 class="mb-0 invoice-customer">${form.category}</h6>
                                <span class="fs-3 invoice-id text-truncate text-body-color d-block w-85">
                                    ${form.rs_no}
                                </span>
                                <span class="fs-3 invoice-date text-nowrap text-body-color d-block">
                                    ${form.new_created_at}
                                </span>
                            </div>
                        </a>`;
                    }
                });
                $('#list-form2').html(listForm);
            });
        </script>
    @endpush
</x-app-layout>
