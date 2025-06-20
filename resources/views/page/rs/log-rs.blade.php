<x-app-layout>
    @section('title')
        Log Requisition Slip
    @endsection

    @push('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.min.css">
        <style>
            .header-item {
                background-color: #f8f9fa;
            }
        </style>
    @endpush


    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Log Requisition Slip</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Log Requisition Slip</li>
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

    <div class="card">
        <div class="card-body">
           <div class="table-responsive">
            <table class="table table-striped table-bordered" id="rsTable">
                <thead class="header-item">
                    <th>No</th>
                    <th>Name</th>
                </thead>
                <tbody>
                    <!-- start row -->

                </tbody>
            </table>
           </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#rsTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: "{{ route('rs.getLog') }}",
                        type: "GET",
                        dataSrc: function(json) {
                            console.log(json);
                            return json; // Adjust based on your API response structure
                        }
                    },
                    columns: [
                        { data: null, name: 'DT_RowIndex', orderable: false, searchable: false,
                            render: (data, type, row, meta) => meta.row + 1 },
                        { data: 'log_name', name: 'name' }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
