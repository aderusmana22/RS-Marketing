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
</x-app-layout>

</html>