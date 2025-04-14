<x-app-layout>
@section('title')
    Requisition Slip Form
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
        h4, h5 {
            color: #343a40;
        }
        .form-label {
            font-weight: bold;
            color: #495057;
        }
        .table {
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
        }
        .table th {
            background-color: #2097f2;
            color: rgb(0, 0, 0);
            text-align: center;
        }
        .table td {
            vertical-align: middle;
        }
        .table input {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .table input:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-submit {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
</style>
@endpush

<body class="bg-light">
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 w-100">
                        <img src="logo.png" alt="" height="80">

                <h4 class="text-center mb-3">REQUISITION SLIP (PACKAGING)</h4>
                <h5 class="text-center mb-4">SALES & MARKETING</h5>

                <div class="mb-3">
                    <label class="form-label">Category:</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                        <option selected disabled>Select</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                    </select>
                </div>

                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Name:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adress:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">SRS Number:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Reason:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">FORM NO:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">REVISION:</label>
                                <input type="text" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">DATE:</label>
                                <input type="date" class="form-control" value="">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remark (Batch Code):</label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent Item:</label>
                        <select class="form-select form-select-sm w-25" aria-label=".form-select-sm example">
                            <option selected disabled>...</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ITEM CODE</th>
                                    <th>PRODUCT NAME</th>
                                    <th>UNIT</th>
                                    <th>QTY REQUIRED</th>
                                    <th>QTY ISSUED</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" value=""></td>
                                    <td><input type="text" class="form-control" value=""></td>
                                    <td><input type="text" class="form-control" value=""></td>
                                    <td><input type="text" class="form-control" value=""></td>
                                    <td><input type="text" class="form-control"></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        
                        
                        <table class="table">
                            <thead style="position: relative;">
                                <tr>
                                    <th>Approvers</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Initiator</td>
                                    <td>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                            <option selected disabled>Select</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Sales & Marketing Dept. Head</td>
                                    <td>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                            <option selected disabled>Select</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Finance & Admin Business Control Manager</td>
                                    <td>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                            <option selected disabled>Select</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Supply Chain Dept. Head</td>
                                    <td>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                            <option selected disabled>Select</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>