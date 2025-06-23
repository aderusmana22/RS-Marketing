<x-app-layout>
     @section('title')
        Submit Requisition Slip
     @endsection
    @push('css')
        <link href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

            h4,
            h5 {
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

            .btn-submit {
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
            }

            .btn-submit:hover {
                background-color: #218838;
            }
        </style>
    @endpush


    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <img src="{{ asset('assets/images/logos/logoputih.png') }}" alt="" height="80">
                <h4 class="text-center mb-3">REQUISITION SLIP (SAMPLE PRODUCT)</h4>
                <h5 class="text-center mb-4">SALES & MARKETING</h5>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('requisition.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">FORM NO:</label>
                            <input type="text" class="form-control" name="rs_no" id="form_no" value=""
                                required readonly placeholder="Press Enter to generate Form NO.">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Initiators:</label>
                            <select class="form-select form-select-sm" name="initiator_nik" id='selectInitiator'>
                                <option selected disabled>Select</option>
                                @foreach ($initiators as $initiator)
                                    <option value="{{ $initiator->nik }}">{{ $initiator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category:</label>
                        <select class="form-select form-select-sm" name="category" id='selectCategory'>
                            {{-- <option value="Packaging">Packaging</option> --}}
                            <option value="Sample Product" selected>Sample Product</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Name:</label>
                                <select name="customer_id" id="customers_id" class="form-select">
                                    <option value="">Select customer</option>
                                    @foreach ($customers as $cust)
                                        <option value="{{ $cust->id }}" data-address="{{ $cust->address }}">
                                            {{ $cust->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div id="dynamicFields">
                                </div>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Address:</label>
                                <input type="text" class="form-control" name="address" id="address" value=""
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Account:</label>
                                <input type="text" class="form-control" name="account" value="" required>
                            </div>
                            <div class="mb-3" style="display: none;">
                                <label class="form-label">REVISION:</label>
                                <input type="text" class="form-control" name="revision_id" value="1" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">DATE:</label>
                                <input type="date" class="form-control" name="date" value="" required>
                            </div>

                        </div>
                    </div>

                    <div class="mb-3" id="packagingOptions" style="display: none;">
                        <div class="form-check">
                            <input type="checkbox" id="option1" class="form-check-input type-checkbox"
                                value="packaging">
                            <label for="packaging" class="form-check-label">Packaging</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="option2" class="form-check-input type-checkbox"
                                value="Plasticbag">
                            <label for="plasticbag" class="form-check-label">Plastic Bag</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="option3" class="form-check-input type-checkbox" value="Label">
                            <label for="Label" class="form-check-label">Label</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent Item:</label>
                        <select class="form-select form-select-sm w-25" id="item_select" name="parent_item[]"
                            multiple="multiple"> {{-- Added multiple="multiple" --}}
                            <option disabled>Select Parent Item(s)</option> {{-- Changed placeholder text --}}
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}">{{ $item->parent_item_code }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemTable">
                            <thead>
                                <tr>
                                    <th>PRODUCT CODE</th>
                                    <th>PRODUCT NAME</th>
                                    <th>UNIT</th>
                                    <th>QTY REQUIRED</th>
                                    <th>QTY ISSUED</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Table rows will be appended here by JavaScript --}}
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/libs/quill/dist/quill.min.js') }}"></script> --}} {{-- Quill not used, commented out --}}
        {{-- <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script> --}} {{-- Datatables not used, commented out --}}
        {{-- <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.min.js"></script> --}} {{-- Datatables not used, commented out --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const customerSelect = document.getElementById('customers_id');
                const addressInput = document.getElementById('address');
                const selectCategory = document.getElementById('selectCategory');
                const itemSelect = $('#item_select'); // jQuery object for Select2

                // Initialize Select2 on the parent_item select
                itemSelect.select2({
                    placeholder: 'Select Parent Item(s)',
                    allowClear: true,
                    width: '100%'
                });

                // Set current date to the date input
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
                const day = String(today.getDate()).padStart(2, '0');
                document.querySelector('input[name="date"]').value = `${year}-${month}-${day}`;


                // --- Event Listeners ---

                // Auto-fill address based on customer selection
                customerSelect.addEventListener('change', function() {
                    const selected = this.options[this.selectedIndex];
                    const address = selected.getAttribute('data-address') || '';
                    addressInput.value = address;
                });

                // Generate Form No. on Enter key press
                document.getElementById('form_no').addEventListener('keypress', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        fetch('{{ route('rs.noReg') }}')
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('form_no').value = data.rs_no;
                            })
                            .catch(error => {
                                console.error('Error fetching form_no:', error);
                            });
                    }
                });

                // Handle category change to show/hide dynamic fields and packaging options
                selectCategory.addEventListener('change', function() {
                    const category = this.value;
                    const dynamicFields = document.getElementById('dynamicFields');
                    const packagingOptions = document.getElementById('packagingOptions');

                    dynamicFields.innerHTML = ''; // Clear previous fields
                    packagingOptions.style.display = 'none'; // Hide packaging options by default

                    if (category === 'Sample Product') {
                        dynamicFields.innerHTML = `
                            <div class="mb-3">
                                <label class="form-label">Objectives:</label>
                                <input type="text" class="form-control" name="objectives" value="" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cost Center:</label>
                                <input type="text" class="form-control" name="cost_center" value="" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estimasi Potensi:</label>
                                <input type="text" class="form-control" name="est_potential" value="" required>
                            </div>
                        `;
                    } else if (category === 'Packaging') {
                        dynamicFields.innerHTML = `
                            <div class="mb-3">
                                <label class="form-label">Reason:</label>
                                <input type="text" class="form-control" value="" name='reason' placeholder='Input Reason' required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remark (Batch Code):</label>
                                <input type="text" class="form-control" value="" name='batch_code' placeholder='Input Batch' required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Srs Number:</label>
                                <input type="text" class="form-control" name="rs_number" value="" required>
                            </div>
                        `;
                        packagingOptions.style.display = 'block'; // Show checkbox for Packaging
                    }
                });

                // Trigger the change event for selectCategory immediately on load
                // to ensure "Sample Product" fields are visible
                selectCategory.dispatchEvent(new Event('change'));


                // Handle parent item selection change (for multiple items)
                itemSelect.on('change', function() {
                    var selectedItems = $(this).val() || [];
                    var selectedTypes = [];
                    $('.type-checkbox:checked').each(function() {
                        selectedTypes.push($(this).val());
                    });
                    var tbody = $('#itemTable tbody');
                    tbody.empty(); // Clear table first

                    if (selectedItems.length === 0) {
                        tbody.append('<tr><td colspan="5" class="text-center">No data available</td></tr>'); // Corrected colspan to 5
                        return;
                    }

                    // Prepare an array of AJAX requests
                    var requests = selectedItems.map(function(selectedItem) {
                        var requestData = {
                            id: selectedItem
                        };
                        if (selectedTypes.length > 0) {
                            requestData.types = selectedTypes;
                        }
                        return $.ajax({
                            url: '{{ route('requisition.getproductdata', ':id') }}'.replace(':id', selectedItem),
                            type: 'GET',
                            data: requestData,
                            dataType: 'json',
                        });
                    });

                    // Execute all AJAX requests and handle their responses
                    $.when.apply($, requests).done(function() {
                        var responses = Array.isArray(arguments[0]) ? arguments : [arguments]; // Normalize responses to always be an array of arrays

                        var itemIds = new Set(); // To prevent duplicate rows

                        for (var i = 0; i < responses.length; i++) {
                            // The actual response data is usually in responses[i][0] for multiple requests
                            var responseData = responses[i][0];
                            if (!responseData || !responseData.data) continue;

                            var items = responseData.data;

                            if (!items || items.length === 0) continue;

                            items.forEach(function(item) {
                                if (!itemIds.has(item.id)) {
                                    itemIds.add(item.id);
                                    var row = `
                                        <tr data-item-id="${item.id}">
                                            <td><input type="text" class="form-control" name="item_detail_code[]" value="${item.item_detail_code}" required readonly></td>
                                            <input type="hidden" class="form-control" name="item_detail_id[]" value="${item.id}">
                                            <td>${item.item_detail_name}</td>
                                            <td>${item.unit}</td>
                                            <td><input type="number" class="form-control" name="qty_req[]" value="" required></td>
                                            <td><input type="number" class="form-control" name="qty_issued[]" value="" required></td>
                                        </tr>`;
                                    tbody.append(row);
                                }
                            });
                        }
                        // If no items were added after processing all responses, show "No data available"
                        if (tbody.children().length === 0) {
                             tbody.append('<tr><td colspan="5" class="text-center">No data available</td></tr>');
                        }
                    }).fail(function() {
                        console.error('One or more AJAX requests failed.');
                        tbody.append('<tr><td colspan="5" class="text-center">Error loading data. Please try again.</td></tr>');
                    });
                });


                // Remove row from table when an item is unselected from parent_item select2
                itemSelect.on('select2:unselect', function(e) {
                    var unselectedId = e.params.data.id;
                    $('#itemTable tbody tr[data-item-id="' + unselectedId + '"]').remove();
                    // If no rows remain, display "No data available" message
                    if ($('#itemTable tbody tr').length === 0) {
                        $('#itemTable tbody').append('<tr><td colspan="5" class="text-center">No data available</td></tr>'); // Corrected colspan to 5
                    }
                });

                // Initial load of table if any item is pre-selected (though your current code doesn't pre-select)
                // This ensures if you later decide to pre-fill the select2, the table will populate.
                if (itemSelect.val() && itemSelect.val().length > 0) {
                    itemSelect.trigger('change');
                } else {
                    $('#itemTable tbody').append('<tr><td colspan="5" class="text-center">No data available</td></tr>');
                }
            });
        </script>
    @endpush

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
