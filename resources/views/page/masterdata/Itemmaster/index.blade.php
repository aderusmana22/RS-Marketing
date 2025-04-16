<x-app-layout>
@section('title')
        Item Master
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
                    <h1 class="font-weight-medium mb-0 ml-3">Item Master</h1>
                    <nav aria-label="breadcrumb mr-3">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home
                                </a>
                            </li>
                            <li class="breadcrumb-item text-muted" aria-current="page">Masters</li>
                        </ol>
                    </nav>
            </div>
        </div>
    </div>

    <div class="widget-content searchable-container list">
            <div class="row">
                <div
                    class="col-md-12 col-xl-12 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0 mb-3">
                    <button type="button" class="btn mb-1 bg-primary text-white px-4 fs-4 hover:bg-primary-dark"
                        data-bs-toggle="modal" data-bs-target="#addItemMasterModal">
                        <i class="ti ti-users text-white me-1 fs-5"></i> Add Item Master
                    </button>
                </div>
            </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap" id="itemmasterTable">
                    <thead class="header-item">
                        <th>No</th>
                        <th>Parent Item</th>
                        <th>Item Code</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td><h6>{{ $loop->iteration }}</h6></td>
                                <td><h6>{{ $item->parent_item }}</h6></td>
                                <td><h6>{{ $item->item_code }}</h6></td>
                                <td>
                                    <div class="action-btn">
                                        <a href="javascript:void(0)" class="text-primary edit" data-bs-toggle="modal"
                                            data-bs-target="#edititemModal{{ $item->id }}">
                                            <i class="ti ti-eye fs-5"></i>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('item-master.destroy', $item->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <a href="javascript:void(0)" class="text-dark delete ms-2"
                                                data-department-id="{{ $item->id }}">
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

    <!-- Modal Add Master -->
    <div class="modal fade" id="additemModal" tabindex="-1" role="dialog" aria-labelledby="additemlModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary text-white">
                    <h5 class="modal-title text-white">Add Parent Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('item-master.store') }}" method="POST">
                        @csrf
                        <div class="box">
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="tb-name"
                                                    placeholder="Enter parent item here" name="name">
                                                <label for="tb-name">Parent item</label>
                                            </div>
                                            <span class="validation-text text-danger"></span>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="item_code" name="itemcode">
                                                    <option value="">Select item code</option>
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="item_code">Parent item code</label>
                                            </div>
                                            <span class="validation-text text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex gap-6 m-0">
                        <button type="submit" class="btn btn-success">Add</button>
                        </form>
                        <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    


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
                        var userId = this.getAttribute('data-itemmaster-id');
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