<x-app-layout>
    @section('title')
        Dashboard
    @endsection

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.css">
    @endpush

    <!-- Breadcrumb -->
    <div class="row">
        <!-- Welcome Card - Full Width -->
        <div class="col-12 d-flex align-items-stretch mb-4">
            <div class="card w-100 bg-primary-subtle overflow-hidden shadow-none">
                <div class="card-body position-relative">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex align-items-center mb-7">
                                <div class="rounded-circle overflow-hidden me-6">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ asset('storage/uploads/user_avatars/' . Auth::user()->avatar) }}" alt="modernize-img" width="40" height="40">
                                    @else
                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="modernize-img" width="40" height="40">
                                    @endif
                                </div>
                                <h5 class="fw-semibold mb-0 fs-5">Welcome, {{ Auth::user()->name }}!</h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="border-end pe-4 border-muted border-opacity-10">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">5<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                                    <p class="mb-0 text-dark">Today's Requisition Slip</p>
                                </div>
                                <div class="ps-4">
                                    <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">40<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                                    <p class="mb-0 text-dark">Overall Requisition Slip</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="welcome-bg-img mb-n7 text-end">
                                <img src="{{ asset('assets/images/backgrounds/welcome-bg.svg') }}" alt="modernize-img" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Cards Row -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title fw-semibold">Requisition Slip Updates</h4>
                    <p class="card-subtitle mb-4">Overview of Requests</p>
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <span class="round-8 text-bg-primary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2">Pending</span>
                        </div>
                        <div>
                            <span class="round-8 text-bg-secondary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2">Approved</span>
                        </div>
                    </div>
                    <div id="revenue-chart" class="revenue-chart mx-n3"></div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title fw-semibold">Requesition Slip Overview</h4>
                    <p class="card-subtitle mb-2">Monthly Requests</p>
                    <div id="sales-overview" class="mb-4"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots fs-6"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark fs-4 mb-0">Pending</h6>
                                <p class="fs-3 mb-0 fw-normal">Requests</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-secondary-subtle text-secondary rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                <i class="ti ti-grid-dots fs-6"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark fs-4 mb-0">Approved</h6>
                                <p class="fs-3 mb-0 fw-normal">Requests</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Requisitions Card - Expanded -->
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h4 class="card-title mb-9 fw-semibold">Monthly Requisitions</h4>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fw-semibold mb-0 me-8">Pending</h4>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 rounded-circle bg-success-subtle text-success round-20 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-arrow-up-left"></i>
                                    </span>
                                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="p-2 bg-primary-subtle rounded-2 d-inline-block">
                                    <img src="../assets/images/svgs/icon-master-card-2.svg" alt="modernize-img" class="img-fluid" width="24" height="24">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="monthly-earning"></div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title fw-semibold">Weekly Requisition Stats</h4>
                    <p class="card-subtitle mb-0">Average Requests</p>
                    <div id="weekly-stats" class="mb-4 mt-7"></div>
                    <div class="position-relative">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex">
                                <div class="p-6 bg-primary-subtle text-primary rounded-2 me-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">Top Requests</h6>
                                    <p class="fs-3 mb-0">Johnathan Doe</p>
                                </div>
                            </div>
                            <div class="bg-primary-subtle text-primary badge">
                                <p class="fs-3 fw-semibold mb-0">+68</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex">
                                <div class="p-6 bg-success-subtle text-success rounded-2 me-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">Best Request</h6>
                                    <p class="fs-3 mb-0">Footware</p>
                                </div>
                            </div>
                            <div class="bg-success-subtle text-success badge">
                                <p class="fs-3 fw-semibold mb-0">+68</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex">
                                <div class="p-6 bg-danger-subtle text-danger rounded-2 me-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fs-4 fw-semibold">......</h6>
                                    <p class="fs-3 mb-0">..........</p>
                                </div>
                            </div>
                            <div class="bg-danger-subtle text-danger badge">
                                <p class="fs-3 fw-semibold mb-0">+68</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div>
                        <h4 class="card-title fw-semibold">Yearly Requisitions</h4>
                        <p class="card-subtitle">Every month</p>
                        <div id="salary" class="mb-7 pb-8 mx-n4"></div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <p class="fs-3 mb-0 fw-normal">Total Requests</p>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0">36,358</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-light-subtle text-muted rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <p class="fs-3 mb-0 fw-normal">Expenses</p>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0">5,296</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Summary Card -->
        <div class="col-md-12 col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title fw-semibold">Request Summary</h4>
                    <p class="card-subtitle mb-4">Overall Performance</p>
                    <div id="expense" class="mb-4"></div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning-subtle text-warning rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                <i class="ti ti-clock fs-6"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark fs-4 mb-0">Processing</h6>
                                <p class="fs-3 mb-0 fw-normal">In Progress</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success-subtle text-success rounded-2 me-8 p-8 d-flex align-items-center justify-content-center">
                                <i class="ti ti-check fs-6"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold text-dark fs-4 mb-0">Completed</h6>
                                <p class="fs-3 mb-0 fw-normal">Finished</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')

    @endpush

</x-app-layout>