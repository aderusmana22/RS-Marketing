<x-app-layout>
    @section('title')
        List Approval Requisition Slip
    @endsection

    @push('css')
    @endpush


    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">List Approval Requisition Slip</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Approval RS</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3 text-end">
                    <button onclick="history.back()" class="btn btn-sm btn-primary">Back</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
           <div class="table-responsive">
            <table class="table table-bordered" id="approvalTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>RS Number</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
           </div>
        </div>
    </div>

    @push('scripts')
        

        <script>
            $(document).ready(function() {
                $('#approvalTable').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: "{{ route('rs.get-approval-list') }}",
                        type: "GET",
                        dataSrc: function(json) {
                            console.log(json);
                            return json;
                        }
                    },
                    columns: [
                        { data: null, render: (data, type, row, meta) => meta.row + 1 },
                        { data: 'rs_no' },
                        { data: 'category' },
                        { data: null,
                            render: function(data, type, row) {
                                const viewUrl = "{{ route('rs.status', ':id') }}".replace(':id', row.no);
                                const approveUrl = "{{ route('rs.approve', ':id') }}".replace(':id', row.no);
                                const rejectUrl = "{{ route('rs.reject', ':id') }}".replace(':id', row.no);
                                
                                return `
                                    <a href="${viewUrl}" class="btn btn-sm btn-info">View</a>
                                    <a href="${approveUrl}" class="btn btn-sm btn-success mx-1">Approve</a>
                                    <a href="${rejectUrl}" class="btn btn-sm btn-danger">Reject</a>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>

