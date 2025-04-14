<x-app-layout>
    @section('title')
        Report Requisition Slip
    @endsection

    @push('css')
    @endpush


    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Report Requisition Slip</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Report Requisition Slip</li>
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
        <div class="d-flex align-items-center justify-content-between gap-6 m-3 d-lg-none">
            <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#chat-sidebar" aria-controls="chat-sidebar">
                <i class="ti ti-menu-2 fs-5"></i>
            </button>
            <form class="position-relative w-100">
                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                    placeholder="Search Contact">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
        </div>
        <div class="d-flex">
            <div class="w-25 d-none d-lg-block border-end user-chat-box">
                <div class="p-3 border-bottom">
                    <form class="position-relative">
                        <input type="search" class="form-control search-invoice ps-5" id="text-srh"
                            placeholder="Search Report">
                        <i
                            class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="app-invoice">
                    <ul class="overflow-auto invoice-users" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" tabindex="0" role="region"
                                        aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                                    id="invoice-123" data-invoice-id="123">
                                                    <div
                                                        class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                                        <i class="ti ti-user fs-6"></i>
                                                    </div>
                                                    <div class="ms-3 d-inline-block w-75">
                                                        <h6 class="mb-0 invoice-customer">James Anderson</h6>

                                                        <span
                                                            class="fs-3 invoice-id text-truncate text-body-color d-block w-85">Id:
                                                            #123</span>
                                                        <span
                                                            class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                                            Fab 2020</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user bg-light-subtle"
                                                    id="invoice-124" data-invoice-id="124">
                                                    <div
                                                        class="btn btn-danger round rounded-circle d-flex align-items-center justify-content-center px-2">
                                                        <i class="ti ti-user fs-6"></i>
                                                    </div>
                                                    <div class="ms-3 d-inline-block w-75">
                                                        <h6 class="mb-0 invoice-customer">Bianca Doe</h6>
                                                        <span
                                                            class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#124</span>
                                                        <span
                                                            class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                                            Fab 2020</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                                    id="invoice-125" data-invoice-id="125">
                                                    <div
                                                        class="btn btn-info round rounded-circle d-flex align-items-center justify-content-center px-2">
                                                        <i class="ti ti-user fs-6"></i>
                                                    </div>
                                                    <div class="ms-3 d-inline-block w-75">
                                                        <h6 class="mb-0 invoice-customer">Angelina Rhodes</h6>
                                                        <span
                                                            class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#125</span>
                                                        <span
                                                            class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                                            Fab 2020</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                                    id="invoice-126" data-invoice-id="126">
                                                    <div
                                                        class="btn btn-warning round rounded-circle d-flex align-items-center justify-content-center px-2">
                                                        <i class="ti ti-user fs-6"></i>
                                                    </div>
                                                    <div class="ms-3 d-inline-block w-75">
                                                        <h6 class="mb-0 invoice-customer">Samuel Smith</h6>
                                                        <span
                                                            class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#126</span>
                                                        <span
                                                            class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                                            Fab 2020</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)"
                                                    class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                                    id="invoice-127" data-invoice-id="127">
                                                    <div
                                                        class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                                        <i class="ti ti-user fs-6"></i>
                                                    </div>
                                                    <div class="ms-3 d-inline-block w-75">
                                                        <h6 class="mb-0 invoice-customer">Gabriel Jobs</h6>
                                                        <span
                                                            class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#127</span>
                                                        <span
                                                            class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                                            Fab 2020</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li></li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
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
                        <div class="invoice-header d-flex align-items-center border-bottom p-3">
                            <h4 class=" text-uppercase mb-0">Invoice</h4>
                            <div class="ms-auto">
                                <h4 class="invoice-number">#124</h4>
                            </div>
                        </div>
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
                                                    <img src="logo.png"class="logo">
                                                </div>
                                                <div class="col-6 text-end">
                                                    <h6 class="mb-1">FORM NO.: FA-INV-05</h6>
                                                    <h6 class="mb-1">REVISION: 3</h6>
                                                    <h6>DATE: 19 FEBRUARY 2021</h6>
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
                                                    <p class="mb-1"><strong>CUSTOMER NAME:</strong> <span class="blue-text">PT AMA</span></p>
                                                    <p class="mb-1"><strong>ADDRESS:</strong> <span class="blue-text">MEDAN</span></p>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <p class="mb-1"><strong>Account:</strong> <span class="blue-text">4914</span></p>
                                                    <p class="mb-1"><strong>Tanggal:</strong> <span class="blue-text">16 Oktober 2024</span></p>
                                                    <p><strong>Nomor SRS:</strong> <span class="blue-text">P 24 10 542</span></p>
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

                            <!-- Signature Section -->
                            <form id="form" method="POST" class="w-full">
                                <div id="aprove/reject" class="d-flex flex-column align-items-center">
                                    <input type="hidden" name="formId" value="">
                                    <textarea name="comment" id="comment" class="m-2 form-control rounded-lg w-100 border border-3" style="max-width:450px; resize: none;" rows="5" placeholder="Tulis komentar disini..."></textarea>
                                    <div id="textarea-warning" class="d-none fw-bold text-danger">Tolong isi kolom komentar.</div>
                                    <div class="w-full flex" style="justify-content: space-evenly;">
                                        <div class="flex sm:!flex-row flex-col mt-2">
                                            <input type="hidden" name="action" id="action" value="">
                                            <button type="button" name="action" value="approve" class="m-2 px-4 py-2 btn btn-success" onclick="submitForm('approve')">
                                                Approve
                                            </button>
                                            <button type="button" name="action" value="approve" class="m-2 px-4 py-2 btn btn-warning" onclick="validateForm('approve')">
                                                Approve with Review
                                            </button>
                                            <button type="button" name="action" value="reject" class="m-2 px-4 py-2 btn btn-danger" onclick="validateForm('reject')">
                                                Not Approved
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            @push('scripts')

                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
                                <script>
                                        function submitForm(value) {
                                            // SweetAlert2 confirmation dialog for submit action
                                            const input = document.getElementById('action')
                                            input.value = value;
                                            Swal.fire({
                                                title: value === 'approve' ? "Do you want to approve?" : "Do you want to reject?",
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#26D639',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes!',
                                                cancelButtonText: 'Cancel'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $("#form").submit();
                                                }
                                            });
                                        }
                                        
                                        function validateForm(type) {
                                            var comment = document.getElementById('comment').value.trim();
                                            var warning = document.getElementById('textarea-warning');
                                            if (comment === '') {
                                                warning.classList.remove('d-none'); 
                                            }else{
                                                warning.classList.add('d-none'); 
                                                // submitForm(type);
                                            }
                                        }
                                    
                                        </script>
                                  @endpush
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="text-end">
                                            <button class="btn bg-danger-subtle text-danger" type="submit">
                                                Proceed to payment
                                            </button>
                                            <button class="btn btn-primary btn-default print-page ms-6"
                                                type="button">
                                                <span>
                                                    <i class="ti ti-printer fs-5"></i>
                                                    Print
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 3 -->
                            <div class="invoice-125" id="printableArea" style="display: none;">
                                <div class="row pt-3">
                                    <div class="col-md-12">
                                        <div>
                                            <address>
                                                <h6>&nbsp;From,</h6>
                                                <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                                                <p class="ms-1">
                                                    1108, Clair Street,
                                                    <br>Massachusetts,
                                                    <br>Woods Hole - 02543
                                                </p>
                                            </address>
                                        </div>
                                        <div class="text-end">
                                            <address>
                                                <h6>To,</h6>
                                                <h6 class="fw-bold invoice-customer">
                                                    Angelina Rhodes,
                                                </h6>
                                                <p class="ms-4">
                                                    455, Shobe Lane,
                                                    <br>Colorado,
                                                    <br>Fort
                                                    Collins - 80524
                                                </p>
                                                <p class="mt-4 mb-1">
                                                    <span>Invoice Date :</span>
                                                    <i class="ti ti-calendar"></i>
                                                    23rd Jan 2021
                                                </p>
                                                <p>
                                                    <span>Due Date :</span>
                                                    <i class="ti ti-calendar"></i>
                                                    25th Jan 2021
                                                </p>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-5">
                                            <table class="table table-hover">
                                                <thead>
                                                    <!-- start row -->
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Description</th>
                                                        <th class="text-end">Quantity</th>
                                                        <th class="text-end">Unit Cost</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                    <!-- end row -->
                                                </thead>
                                                <tbody>
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Milk Powder</td>
                                                        <td class="text-end">2</td>
                                                        <td class="text-end">$24</td>
                                                        <td class="text-end">$48</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>Air Conditioner</td>
                                                        <td class="text-end">5</td>
                                                        <td class="text-end">$500</td>
                                                        <td class="text-end">$2500</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>RC Cars</td>
                                                        <td class="text-end">30</td>
                                                        <td class="text-end">$600</td>
                                                        <td class="text-end">$18000</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td>Down Coat</td>
                                                        <td class="text-end">62</td>
                                                        <td class="text-end">$5</td>
                                                        <td class="text-end">$310</td>
                                                    </tr>
                                                    <!-- end row -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="pull-right mt-4 text-end">
                                            <p>Sub - Total amount: $20,858</p>
                                            <p>vat (10%) : $2,085</p>
                                            <hr>
                                            <h3>
                                                <b>Total :</b> $22,943
                                            </h3>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="text-end">
                                            <button class="btn bg-danger-subtle text-danger" type="submit">
                                                Proceed to payment
                                            </button>
                                            <button class="btn btn-primary btn-default print-page ms-6"
                                                type="button">
                                                <span>
                                                    <i class="ti ti-printer fs-5"></i>
                                                    Print
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 4 -->
                            <div class="invoice-126" id="printableArea" style="display: none;">
                                <div class="row pt-3">
                                    <div class="col-md-12">
                                        <div>
                                            <address>
                                                <h6>&nbsp;From,</h6>
                                                <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                                                <p class="ms-1">
                                                    1108, Clair Street,
                                                    <br>Massachusetts,
                                                    <br>Woods Hole - 02543
                                                </p>
                                            </address>
                                        </div>
                                        <div class="text-end">
                                            <address>
                                                <h6>To,</h6>
                                                <h6 class="fw-bold invoice-customer">
                                                    Samuel Smith,
                                                </h6>
                                                <p class="ms-4">
                                                    455, Shobe Lane,
                                                    <br>Colorado,
                                                    <br>Fort
                                                    Collins - 80524
                                                </p>
                                                <p class="mt-4 mb-1">
                                                    <span>Invoice Date :</span>
                                                    <i class="ti ti-calendar"></i>
                                                    23rd Jan 2021
                                                </p>
                                                <p>
                                                    <span>Due Date :</span>
                                                    <i class="ti ti-calendar"></i>
                                                    25th Jan 2021
                                                </p>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-5">
                                            <table class="table table-hover">
                                                <thead>
                                                    <!-- start row -->
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Description</th>
                                                        <th class="text-end">Quantity</th>
                                                        <th class="text-end">Unit Cost</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                    <!-- end row -->
                                                </thead>
                                                <tbody>
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Milk Powder</td>
                                                        <td class="text-end">2</td>
                                                        <td class="text-end">$24</td>
                                                        <td class="text-end">$48</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>Air Conditioner</td>
                                                        <td class="text-end">5</td>
                                                        <td class="text-end">$500</td>
                                                        <td class="text-end">$2500</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>RC Cars</td>
                                                        <td class="text-end">30</td>
                                                        <td class="text-end">$600</td>
                                                        <td class="text-end">$18000</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td>Down Coat</td>
                                                        <td class="text-end">62</td>
                                                        <td class="text-end">$5</td>
                                                        <td class="text-end">$310</td>
                                                    </tr>
                                                    <!-- end row -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="pull-right mt-4 text-end">
                                            <p>Sub - Total amount: $20,858</p>
                                            <p>vat (10%) : $2,085</p>
                                            <hr>
                                            <h3>
                                                <b>Total :</b> $22,943
                                            </h3>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="text-end">
                                            <button class="btn bg-danger-subtle text-danger" type="submit">
                                                Proceed to payment
                                            </button>
                                            <button class="btn btn-primary btn-default print-page ms-6"
                                                type="button">
                                                <span>
                                                    <i class="ti ti-printer fs-5"></i>
                                                    Print
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 5 -->
                            <div class="invoice-127" id="printableArea" style="display: none;">
                                <div class="row pt-3">
                                    <div class="col-md-12">
                                        <div>
                                            <address>
                                                <h6>&nbsp;From,</h6>
                                                <h6 class="fw-bold">&nbsp;Steve Jobs</h6>
                                                <p class="ms-1">
                                                    1108, Clair Street,
                                                    <br>Massachusetts,
                                                    <br>Woods Hole - 02543
                                                </p>
                                            </address>
                                        </div>
                                        <div class="text-end">
                                            <address>
                                                <h6>To,</h6>
                                                <h6 class="fw-bold invoice-customer">
                                                    Gabriel Jobs,
                                                </h6>
                                                <p class="ms-4">
                                                    455, Shobe Lane,
                                                    <br>Colorado,
                                                    <br>Fort
                                                    Collins - 80524
                                                </p>
                                                <p class="mt-4 mb-1">
                                                    <span>Invoice Date :</span>
                                                    <i class="ti ti-calendar"></i>
                                                    23rd Jan 2021
                                                </p>
                                                <p>
                                                    <span>Due Date :</span>
                                                    <i class="ti ti-calendar"></i>
                                                    25th Jan 2021
                                                </p>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-5">
                                            <table class="table table-hover">
                                                <thead>
                                                    <!-- start row -->
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Description</th>
                                                        <th class="text-end">Quantity</th>
                                                        <th class="text-end">Unit Cost</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                    <!-- end row -->
                                                </thead>
                                                <tbody>
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Milk Powder</td>
                                                        <td class="text-end">2</td>
                                                        <td class="text-end">$24</td>
                                                        <td class="text-end">$48</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">2</td>
                                                        <td>Air Conditioner</td>
                                                        <td class="text-end">5</td>
                                                        <td class="text-end">$500</td>
                                                        <td class="text-end">$2500</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">3</td>
                                                        <td>RC Cars</td>
                                                        <td class="text-end">30</td>
                                                        <td class="text-end">$600</td>
                                                        <td class="text-end">$18000</td>
                                                    </tr>
                                                    <!-- end row -->
                                                    <!-- start row -->
                                                    <tr>
                                                        <td class="text-center">4</td>
                                                        <td>Down Coat</td>
                                                        <td class="text-end">62</td>
                                                        <td class="text-end">$5</td>
                                                        <td class="text-end">$310</td>
                                                    </tr>
                                                    <!-- end row -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="pull-right mt-4 text-end">
                                            <p>Sub - Total amount: $20,858</p>
                                            <p>vat (10%) : $2,085</p>
                                            <hr>
                                            <h3>
                                                <b>Total :</b> $22,943
                                            </h3>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="text-end">
                                            <button class="btn bg-danger-subtle text-danger" type="submit">
                                                Proceed to payment
                                            </button>
                                            <button class="btn btn-primary btn-default print-page ms-6"
                                                type="button">
                                                <span>
                                                    <i class="ti ti-printer fs-5"></i>
                                                    Print
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-start user-chat-box" tabindex="-1" id="chat-sidebar"
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
                        <input type="search" class="form-control search-invoice ps-5" id="text-srh"
                            placeholder="Search Invoice">
                        <i
                            class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="app-invoice overflow-auto">
                    <ul class="invoice-users">
                        <li>
                            <a href="javascript:void(0)"
                                class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user bg-light"
                                id="invoice-123" data-invoice-id="123">
                                <div
                                    class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                    <i class="ti ti-user fs-6"></i>
                                </div>
                                <div class="ms-3 d-inline-block w-75">
                                    <h6 class="mb-0 invoice-customer">James Anderson</h6>

                                    <span class="fs-3 invoice-id text-truncate text-body-color d-block w-85">Id:
                                        #123</span>
                                    <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9 Fab
                                        2020</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                id="invoice-124" data-invoice-id="124">
                                <div
                                    class="btn btn-danger round rounded-circle d-flex align-items-center justify-content-center px-2">
                                    <i class="ti ti-user fs-6"></i>
                                </div>
                                <div class="ms-3 d-inline-block w-75">
                                    <h6 class="mb-0 invoice-customer">Bianca Doe</h6>
                                    <span
                                        class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#124</span>
                                    <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9 Fab
                                        2020</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                id="invoice-125" data-invoice-id="125">
                                <div
                                    class="btn btn-info round rounded-circle d-flex align-items-center justify-content-center px-2">
                                    <i class="ti ti-user fs-6"></i>
                                </div>
                                <div class="ms-3 d-inline-block w-75">
                                    <h6 class="mb-0 invoice-customer">Angelina Rhodes</h6>
                                    <span
                                        class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#125</span>
                                    <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9 Fab
                                        2020</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                id="invoice-126" data-invoice-id="126">
                                <div
                                    class="btn btn-warning round rounded-circle d-flex align-items-center justify-content-center px-2">
                                    <i class="ti ti-user fs-6"></i>
                                </div>
                                <div class="ms-3 d-inline-block w-75">
                                    <h6 class="mb-0 invoice-customer">Samuel Smith</h6>
                                    <span
                                        class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#126</span>
                                    <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9 Fab
                                        2020</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)"
                                class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user"
                                id="invoice-127" data-invoice-id="127">
                                <div
                                    class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center px-2">
                                    <i class="ti ti-user fs-6"></i>
                                </div>
                                <div class="ms-3 d-inline-block w-75">
                                    <h6 class="mb-0 invoice-customer">Gabriel Jobs</h6>
                                    <span
                                        class="fs-3 invoice-id text-truncate text-body-color d-block w-85">#127</span>
                                    <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9 Fab
                                        2020</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
