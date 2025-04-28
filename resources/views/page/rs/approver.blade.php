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
                                @foreach ($approvers as $approver)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $approver->nik }}</td>
                                        <td>{{ $approver->role }}</td>
                                        <td>{{ $approver->level }}</td>
                                        <td>
                                            <div class="action-btn">
                                                <a href="javascript:void(0)" class="text-primary edit" data-bs-toggle="modal"
                                                    data-bs-target="#editApproverModal{{ $approver->id }}">
                                                    <i class="ti ti-eye fs-5"></i>
                                                </a>
                                                <form id="delete-form-{{ $approver->id }}"
                                                    action="{{ route('rs.approver.destroy', $approver->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="javascript:void(0)" class="text-dark delete ms-2"
                                                        data-user-id="{{ $approver->id }}">
                                                        <i class="ti ti-trash fs-5"></i>
                                                    </a>
                                                </form>
                                            </div>
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
        <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form action="{{ route('rs.approver.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addApproverModalLabel">Add Approver</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-12 mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <select name="nik" class="form-control select2" required>
                                    <option value="">Choose NIK</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->nik }}">{{ $user->nik }} - {{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" class="form-control select2" multiple="multiple" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="level" class="form-label">Level</label>
                                <input type="number" name="level" class="form-control" placeholder="Enter level" required>
                            </div>
                        </div> 
                        <div class="modal-footer">
                            <div class="d-flex gap-6 m-0">
                                <button type="submit" class="btn btn-success">Add</button>
                                
                            <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Close</button> 
                            </div>  
                        </div>

                    </div>
                </form>
                
            </div>
        </div>


    <!-- Edit Approver Modal -->
    @foreach ($approvers as $approver)
    <div class="{{$approver}}"></div>
    <div class="modal fade" id="editApproverModal{{ $approver->id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form action="{{ route('rs.approver.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Approver</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-12 mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <select name="nik" class="form-control select2" required>
                                <option value="">Choose NIK</option>
                                @foreach ($users as $username)
                                    <option value="{{ $username->nik }}" {{ $username->nik === $approver->nik ? 'selected' : '' }}>
                                        {{ $username->nik }} - {{ $username->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-control select2" required>
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}" {{ $role == $user->role ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="level" class="form-label">Level</label>
                            <input type="number" name="level" class="form-control" value="{{ $user->level }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex gap-6 m-0">
                            <button type="submit" class="btn btn-success">Update</button>
                        
                            <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Close
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach


        

        
            @push('scripts')
            <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
            <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
            <script src="{{ asset('assets') }}/libs/datatables.net/js/jquery.dataTables.min.js"></script>
            <script src="{{ asset('assets') }}/js/datatable/datatable-basic.init.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var approver = @json($approvers);
                    console.log(approver);
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