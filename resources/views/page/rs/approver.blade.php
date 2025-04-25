<x-app-layout>
    @section('title')
        Users
    @endsection

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets') }}/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

        <style>
            .select2-container {
                z-index: 9999 !important;
            }
        </style>
    @endpush
    <div class="font-weight-medium shadow-none position-relative overflow-hidden mb-7">
        <div class="card-body px-0">
            <div class="d-flex justify-content-between align-items-center">
                    <h1 class="font-weight-medium mb-0 ml-3">List Users</h1>
                    <nav aria-label="breadcrumb mr-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home
                                </a>
                            </li>
                            <li class="breadcrumb-item text-muted" aria-current="page">Users</li>
                        </ol>
                    </nav>
            </div>
        </div>
    </div>

    <div class="">
            <div class="row">
                <div
                    class="col-md-12 col-xl-12 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0 mb-3">
                    <button type="button" class="btn mb-1 bg-primary text-white px-4 fs-4 hover:bg-primary-dark"
                        data-bs-toggle="modal" data-bs-target="#addContactModal">
                        <i class="ti ti-users text-white me-1 fs-5"></i> Add Approver
                    </button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="userTable">
                            <thead class="header-item">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->level }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger delete" data-user-id="{{ $user->id }}">Delete</button>
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add approver Modal -->
        
        <!-- Editapprover Modal -->
        

        
            @push('scripts')
            <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
            <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
            <script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="{{ asset('assets') }}/js/datatable/datatable-basic.init.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    $('.select2').select2();
        
                    // Initialize DataTable
                    var table = $('#userTable').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    });
        
                    // Function to initialize modal event listeners
                    function initializeModalListeners() {
                        document.querySelectorAll('.delete').forEach(function(element) {
                            element.addEventListener('click', function() {
                                var userId = this.getAttribute('data-user-id');
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
                                        document.getElementById('delete-form-' + userId).submit();
                                    }
                                });
                            });
                        });
                    }
        
                    // Initialize modal listeners on page load
                    initializeModalListeners();
        
                    // Re-initialize modal listeners on DataTable draw event
                    table.on('draw', function() {
                        initializeModalListeners();
                    });
                });
            </script>
        @endpush    


       
</x-app-layout>