<x-app-layout>
    @section('title')
        List Requisition Slip
    @endsection

    @push('css')
    @endpush


    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">List Requisition Slip</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">List Requisition Slip</li>
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

    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-0">Requisition Slip</h5>
            <a href="{{ route('rs.submit') }}" class="btn btn-success btn-sm">Create Form</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="rsTable">
                <thead class="header-item">
                    <tr>
                        <th>No</th>
                        <th>RS Number</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Route To</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
        <script>
            $('#rsTable').dataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('rs.getFormList') }}",
                    type: "GET",
                    dataSrc: function(response) {
                        console.log('test', response);
                        return response;
                    }
                },
                columns: [
                    { data: null, name: 'DT_RowIndex' },
                    { data: 'rs_no', name: 'rs_number' },
                    { data: 'category', name: 'category' },
                    { data: 'status', name: 'status',
                        render: function(data, type, row) {
                            if (data == 'rejected') {
                                return '<span class="text-danger">' + data + '</span>';
                            } else if (data == 'approved') {
                                return '<span class="text-success">' + data + '</span>';
                            } else if (data == 'pending') {
                                return '<span class="text-primary">' + data + '</span>';
                            } if (data == 'draft') {
                                return '<span class="text-body-secondary">' + data + '</span>';
                            } 
                            return data;
                        }
                    },
                    { data: 'route_to', name: 'route_to' },
                    { data: null, name: 'action', orderable: false, searchable: false,
                        render: function(data, type, row) {
                            const viewRoute = "{{ route('rs.list', ':id') }}".replace(':id', row.id);
                            if (data.status === 'Draft') {
                                const editRoute = "{{ route('rs.edit', ':id') }}".replace(':id', row.id);
                                const deleteRoute = "{{ route('rs.destroy', ':id') }}".replace(':id', row.id);
                            
                                return `
                                <div class="d-flex gap-6">
                                    <a href="${editRoute}" class="btn btn-primary btn-sm">Edit</a>
                                    <form id="delete-form-${row.no}" action="${deleteRoute}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <a href="javascript:void(0)" class="btn btn-outline-danger" data-form-no="${row.no}" onclick="deleteForm(this)">
                                            Send Email To GM
                                        </a>
                                    </form>
                                </div>
                                `;
                            } 
                            return `<a href="${viewRoute}" class="btn btn-danger btn-sm">View</a>`;
                        }
                    }
                ],
            });

            // Function untuk konfirmasi delete user
            function confirmDelete(button){
                var formNo = button.getAttribute('data-form-no');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + formNo).submit();
                    }
                });
            }
                
            // Function untuk konfirmasi send email to gm
            function confirmEmail(button){
                var formNo = button.getAttribute('send-form-no');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Email will be send to GM!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send to GM!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('send-form-' + formNo).submit();
                    }
                });
            }
        </script>
    @endpush
    
</x-app-layout>
