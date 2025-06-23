<x-app-layout>
    @section('title')
        Dashboard
    @endsection

    @push('css')
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.3/dist/apexcharts.min.css"> --}}
    @endpush

    <div class="row">
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
                                    <p class="mb-0 text-dark">Total Requisition Slip</p>
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

        <div class="col-lg-6 d-flex align-items-stretch">
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

        <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h4 class="card-title mb-9 fw-semibold">Report Requisitions</h4>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fw-semibold mb-0 me-8">Monthly Overview</h4>
                                <div class="d-flex align-items-center">
                                    <span class="me-2 rounded-circle bg-success-subtle text-success round-20 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-arrow-up-left"></i>
                                    </span>
                                    <p class="text-dark me-1 fs-3 mb-0"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="p-2 bg-primary-subtle rounded-2 d-inline-block">
                                    <img src="{{ asset('assets/images/svgs/icon-master-card-2.svg') }}" alt="modernize-img" class="img-fluid" width="24" height="24">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="monthly-earning"></div>
                </div>
            </div>
        </div>

        {{--- Leaderboard Card ---}}
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title fw-semibold">Top 10 Requisitioners</h4>
                    {{-- Leaderboard Filter Dropdown --}}
                    <div class="mb-3">
                        <label for="leaderboardFilter" class="form-label visually-hidden">Leaderboard Timeframe</label>
                        <select class="form-select form-select-sm w-auto" id="leaderboardFilter">
                            <option value="weekly" class="fw-bold" selected>Weekly</option>
                            <option value="monthly" class="fw-bold">Monthly</option>
                        </select>
                    </div>

                    <div class="position-relative" style="max-height: 400px; overflow-y: auto;">
                        <div id="leaderboard-list">
                            {{-- Leaderboard items will be inserted here by JavaScript --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <h4 class="card-title fw-semibold">Requisition Slip Overview</h4>
                    <p class="card-subtitle mb-2">Monthly Requests</p>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        {{-- Left side: Pending & Approved indicators --}}
                        <div class="d-flex align-items-center">
                            <a href="#" id="pending-requests-link" class="d-flex align-items-center text-decoration-none me-4" onclick="handlePendingClick()">
                                <div class="bg-primary-subtle text-primary rounded-2 me-2 p-2 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0" id="pending-requests-count">20</h6> {{-- Example count --}}
                                    <p class="fs-3 mb-0 fw-normal">Pending</p>
                                </div>
                            </a>
                            <a href="#" id="approved-requests-link" class="d-flex align-items-center text-decoration-none" onclick="handleApprovedClick()">
                                <div class="bg-success-subtle text-success rounded-2 me-2 p-2 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-grid-dots fs-6"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold text-dark fs-4 mb-0" id="approved-requests-count">35</h6> {{-- Example count --}}
                                    <p class="fs-3 mb-0 fw-normal">Approved</p>
                                </div>
                            </a>
                        </div>

                        {{-- Right side: Month and Year filters --}}
                        <div class="d-flex">
                            <div class="me-3">
                                <label for="monthFilter" class="form-label visually-hidden">Select Month</label>
                                <select class="form-select form-select-sm w-auto" id="monthFilter"> {{-- Added w-auto --}}
                                    <option value="01" class="fw-bold">January</option>
                                    <option value="02" class="fw-bold">February</option>
                                    <option value="03" class="fw-bold">March</option>
                                    <option value="04" class="fw-bold">April</option>
                                    <option value="05" class="fw-bold">May</option>
                                    <option value="06" class="fw-bold" selected>June</option>
                                    <option value="07" class="fw-bold">July</option>
                                    <option value="08" class="fw-bold">August</option>
                                    <option value="09" class="fw-bold">September</option>
                                    <option value="10" class="fw-bold">October</option>
                                    <option value="11" class="fw-bold">November</option>
                                    <option value="12" class="fw-bold">December</option>
                                </select>
                            </div>
                            <div>
                                <label for="yearFilter" class="form-label visually-hidden">Select Year</label>
                                <select class="form-select form-select-sm w-auto" id="yearFilter"> {{-- Added w-auto --}}
                                    </select>
                            </div>
                        </div>
                    </div>

                    <div id="requisition-overview-chart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/echarts@5.3.0/dist/echarts.min.js"></script>

        <script>
            // Handle clicks for Pending
            function handlePendingClick() {
                alert('Pending requests clicked!');
                // You can add logic here to redirect, filter data, etc.
                // window.location.href = '/requisitions/pending';
            }

            // Handle clicks for Approved
            function handleApprovedClick() {
                alert('Approved requests clicked!');
                // You can add logic here to redirect, filter data, etc.
                // window.location.href = '/requisitions/approved';
            }

            // ECharts for Requisition Slip Overview
            document.addEventListener('DOMContentLoaded', function() {
                var chartDom = document.getElementById('requisition-overview-chart');
                var myChart = echarts.init(chartDom);
                var option;

                // Function to generate dummy data for the chart based on month and year
                function getChartData(month, year) {
                    const basePending = 100 + (month * 5) + (year - 2025) * 10;
                    const baseApproved = 200 + (month * 10) + (year - 2025) * 15;

                    return {
                        pending: Array.from({length: 12}, (_, i) => Math.floor(basePending + Math.random() * 50 - 25)),
                        approved: Array.from({length: 12}, (_, i) => Math.floor(baseApproved + Math.random() * 70 - 35))
                    };
                }

                // Initialize month and year filters for Requisition Overview
                const monthFilter = document.getElementById('monthFilter');
                const yearFilter = document.getElementById('yearFilter');
                const currentYear = new Date().getFullYear();
                const currentMonth = (new Date().getMonth() + 1).toString().padStart(2, '0');

                // Populate year filter
                for (let i = currentYear - 5; i <= currentYear + 5; i++) {
                    const option = document.createElement('option');
                    option.value = i;
                    option.textContent = i;
                    if (i === currentYear) {
                        option.selected = true;
                    }
                    yearFilter.appendChild(option);
                }

                // Set current month as selected in the filter
                monthFilter.value = currentMonth;


                // Function to update the Requisition Overview chart
                function updateChart() {
                    const selectedMonth = monthFilter.value;
                    const selectedYear = yearFilter.value;
                    const data = getChartData(parseInt(selectedMonth), parseInt(selectedYear));

                    option = {
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                type: 'shadow'
                            }
                        },
                        legend: {
                            data: ['Pending', 'Approved'],
                            show: true,
                            top: 'bottom'
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '10%',
                            containLabel: true
                        },
                        xAxis: {
                            type: 'category',
                            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                        },
                        yAxis: {
                            type: 'value'
                        },
                        series: [
                            {
                                name: 'Pending',
                                type: 'bar',
                                stack: 'total',
                                emphasis: {
                                    focus: 'series'
                                },
                                data: data.pending,
                                itemStyle: {
                                    color: '#5D87FF'
                                }
                            },
                            {
                                name: 'Approved',
                                type: 'bar',
                                stack: 'total',
                                emphasis: {
                                    focus: 'series'
                                },
                                data: data.approved,
                                itemStyle: {
                                    color: '#28a745'
                                }
                            }
                        ]
                    };

                    myChart.setOption(option);
                }

                // Add event listeners to filters
                monthFilter.addEventListener('change', updateChart);
                yearFilter.addEventListener('change', updateChart);

                // Initial chart render
                updateChart();

                // Optional: Resize chart with window
                window.addEventListener('resize', function () {
                    myChart.resize();
                });

                // --- Leaderboard Logic ---
                const leaderboardList = document.getElementById('leaderboard-list');
                const leaderboardFilter = document.getElementById('leaderboardFilter');

                // Dummy data for leaderboard (replace with real data from backend)
                const weeklyRequisitioners = [
                    { name: 'Dinah Dzakiyyah Rasikhah', department: 'Marketing', requisitions: 25 },
                    { name: 'Priyadi Setiawan', department: 'Marsho', requisitions: 22 },
                    { name: 'Kelfin Alamanda', department: 'Marketing', requisitions: 20 },
                    { name: 'Diana Prince', department: 'Marketing', requisitions: 18 },
                    { name: 'Suparman', department: 'Marsho', requisitions: 15 },
                    { name: 'Nahason Haria', department: 'RTM', requisitions: 14 },
                    { name: 'Ayu Untari Putri', department: 'Sales Admin', requisitions: 13 },
                    { name: 'Nyimas Mariam', department: 'Finance', requisitions: 11 },
                    { name: 'Ivy Green', department: 'West Region', requisitions: 10 },
                    { name: 'Ade Rusmana', department: 'IT', requisitions: 9 },
                    { name: 'Andhika Suhendar', department: 'IT', requisitions: 8 },
                    { name: 'Zafira Husna Salsabila', department: 'Marketing', requisitions: 7 },
                ];

                const monthlyRequisitioners = [
                    { name: 'Ellyza Kusuma Wardani', department: 'FinBusiness Controllerance', requisitions: 110 },
                    { name: 'Dinah Dzakiyyah Rasikhah', department: 'Marketing', requisitions: 105 },
                    { name: 'Diana Prince', department: 'Marketing', requisitions: 95 },
                    { name: 'Zafira Husna Salsabila', department: 'Marketing', requisitions: 90 },
                    { name: 'Nandita Shabrina', department: 'Marketing', requisitions: 82 },
                    { name: 'Ayu Untari Putri', department: 'Sales Admin', requisitions: 78 },
                    { name: 'Henry King', department: 'Finance', requisitions: 70 },
                    { name: 'Ade Rusmana', department: 'IT', requisitions: 68 },
                    { name: 'Elia Herlina Dwiyanti', department: 'R & D', requisitions: 60 },
                    { name: 'Ryan Theodorus', department: 'IT', requisitions: 55 },
                    { name: 'Putri Wulandari', department: 'Sales Admin', requisitions: 50 },
                    { name: 'Ivy Green', department: 'West Region', requisitions: 45 },
                ];

                function renderLeaderboard(data) {
                    leaderboardList.innerHTML = ''; // Clear previous entries

                    // Sort by requisitions in descending order
                    data.sort((a, b) => b.requisitions - a.requisitions);

                    // Display up to top 10
                    for (let i = 0; i < Math.min(10, data.length); i++) {
                        const person = data[i];
                        const listItem = document.createElement('div');
                        listItem.classList.add('d-flex', 'align-items-center', 'justify-content-between', 'mb-3');

                        listItem.innerHTML = `
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <span class="fw-bold">${i + 1}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0 fs-4 fw-semibold">${person.name}</h6>
                                    <p class="fs-2 text-muted mb-0">${person.department}</p>
                                </div>
                            </div>
                            <div class="badge bg-primary-subtle text-primary">
                                <p class="fs-3 fw-semibold mb-0">${person.requisitions}</p>
                            </div>
                        `;
                        leaderboardList.appendChild(listItem);
                    }
                }

                // Event listener for the leaderboard filter dropdown
                leaderboardFilter.addEventListener('change', () => {
                    const selectedFilter = leaderboardFilter.value;
                    if (selectedFilter === 'weekly') {
                        renderLeaderboard(weeklyRequisitioners);
                    } else if (selectedFilter === 'monthly') {
                        renderLeaderboard(monthlyRequisitioners);
                    }
                });

                // Initial render of the leaderboard (defaults to Weekly)
                renderLeaderboard(weeklyRequisitioners);
            });
        </script>
    @endpush

</x-app-layout>