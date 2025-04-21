<x-app-layout>
    @section('title')
        Item Details
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
            <h1 class="font-weight-medium mb-0 ml-3">Item Details</h1>
            <nav aria-label="breadcrumb mr-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item text-muted">Items</li>
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
                    data-bs-toggle="modal" data-bs-target="#addItemDetailModal">
                    <i class="ti ti-users text-white me-1 fs-5"></i> Add Item Details
                </button>
            </div>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table align-middle text-nowrap" id="itemDetailsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Master</th>
                            <th>Item Detail Code</th>
                            <th>Item Detail Name</th>
                            <th>Unit</th>
                            <th>Net Weight</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemDetails as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td></td>
                            <td>{{ $detail->item_detail_code }}</td>
                            <td>{{ $detail->item_detail_name }}</td>
                            <td>{{ $detail->unit }}</td>
                            <td>{{ $detail->net_weight }}</td>
                            <td>{{ $detail->type }}</td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-primary edit" data-bs-toggle="modal"
                                        data-bs-target="#edititemdetailModal{{ $detail->id }}">
                                        <i class="ti ti-eye fs-5"></i>
                                    </a>
                                    <form id="delete-form-{{ $detail->id }}"
                                        action="{{ route('item-detail.destroy', $detail->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:void(0)" class="text-dark delete ms-2"
                                            data-department-id="{{ $detail->id }}">
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


<!-- Modal Add Item Detail -->
<div class="modal fade" id="addItemDetailModal" tabindex="-1" role="dialog"
    aria-labelledby="addItemDetailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary text-white">
                <h5 class="modal-title text-white">Add Item Detail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="/itemdetailstore" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="item_master_id" class="form-label">Parent Item</label>
                            <select class="form-select" name="item_master_id" required>
                                <option value="">Select Parent Item</option>
                                @foreach($itemMasters as $master)
                                    <option value="{{ $master->id }}">
                                        {{ $master->parent_item_code }} - {{ $master->parent_item_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="item_detail_code" class="form-label">Item Detail Code</label>
                            <input type="text" name="item_detail_code" class="form-control"
                                 required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="item_detail_name" class="form-label">Item Detail Name</label>
                            <input type="text" name="item_detail_name" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" name="unit" class="form-control" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="net_weight" class="form-label">Net Weight</label>
                            <input type="number" name="net_weight" class="form-control"
                                step="0.01"  required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" name="type" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex gap-6 m-0">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal Edit Item Detail -->
@foreach ($itemDetails as $detail)
<div class="modal fade" id="edititemdetailModal{{ $detail->id }}" tabindex="-1" role="dialog"
    aria-labelledby="edititemdetailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary text-white">
                <h5 class="modal-title text-white">Edit Item Detail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form action="{{ route('item-details.update', $detail->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="item_master_id" class="form-label">Parent Item</label>
                            <select class="form-select" name="item_master_id" required>
                                <option value="">Select Parent Item</option>
                                @foreach($itemMasters as $master)
                                    <option value="{{ $master->id }}"
                                        {{ $detail->item_master_id == $master->id ? 'selected' : '' }}>
                                        {{ $master->parent_item_code }} - {{ $master->parent_item_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="item_detail_code" class="form-label">Item Detail Code</label>
                            <input type="text" name="item_detail_code" class="form-control"
                                value="{{ $detail->item_detail_code }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="item_detail_name" class="form-label">Item Detail Name</label>
                            <input type="text" name="item_detail_name" class="form-control"
                                value="{{ $detail->item_detail_name }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" name="unit" class="form-control"
                                value="{{ $detail->unit }}" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="net_weight" class="form-label">Net Weight</label>
                            <input type="number" name="net_weight" class="form-control"
                                step="0.01" value="{{ $detail->net_weight }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" name="type" class="form-control"
                                value="{{ $detail->type }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex gap-6 m-0">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
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
                        var userId = this.getAttribute('data-itemdetail-id');
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