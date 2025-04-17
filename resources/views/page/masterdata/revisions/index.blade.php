<x-app-layout>
    @section('title')
        Revisions
    @endsection

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    @endpush

    <div class="font-weight-medium shadow-none position-relative overflow-hidden mb-7">
        <div class="card-body px-0">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="font-weight-medium mb-0 ml-3">List Revisions</h1>
                <nav aria-label="breadcrumb mr-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Revisions</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="widget-content searchable-container list">
        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRevisionModal">
                <i class="ti ti-plus"></i> Add Revision
            </button>
        </div>

        <div class="card card-body">
            <div class="table-responsive">
                <table class="table" id="revisionsTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Form No</th>
                            <th>Revision</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($revisions as $revision)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $revision->form_no }}</td>
                                <td>{{ $revision->revision }}</td>
                                <td>{{ \Carbon\Carbon::parse($revision->date)->format('d M Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('revisions.destroy', $revision->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add revision -->
    <div class="modal fade" id="addRevisionModal" tabindex="-1" aria-labelledby="addRevisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('revisions.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Add Revision</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Form No</label>
                        <input type="text" name="form_no" class="form-control" placeholder="Enter Form No" required>
                    </div>
                    <div class="mb-3">
                        <label>Revision</label>
                        <input type="text" name="revision" class="form-control" placeholder="Enter Revision" required>
                    </div>
                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal update revision -->
@foreach ($revisions as $revision)
    <div class="modal fade" id="editRevisionModal{{ $revision->id }}" tabindex="-1" aria-labelledby="editRevisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('revisions.update', $revision->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Edit Revision</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Form No</label>
                        <input type="text" name="form_no" value="{{ $revision->form_no }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Revision</label>
                        <input type="text" name="revision" value="{{ $revision->revision }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="date" value="{{ $revision->date }}" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning text-white">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endforeach


    @push('scripts')
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-basic.init.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var table = $('#revisionTable').DataTable();

                function initializeDeleteListeners() {
                    document.querySelectorAll('.delete').forEach(function(el) {
                        el.addEventListener('click', function() {
                            var id = this.getAttribute('data-revision-id');
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "This action cannot be undone!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('delete-form-' + id).submit();
                                }
                            });
                        });
                    });
                }

                initializeDeleteListeners();
                table.on('draw', initializeDeleteListeners);
            });
        </script>
    @endpush
</x-app-layout>







