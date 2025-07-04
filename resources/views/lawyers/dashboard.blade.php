@extends('layouts.default')

@section('title', 'Lawyer Dashboard')

@push('css')
	<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
	
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<link href="/assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
	
@endpush

@push('styles')
<style>
	.table tbody tr {
	  border-bottom: 1px solid #fff; /* White border */
	}
  
	.widget-link {
    text-decoration: none;
    display: block;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.widget-link:hover .widget-stats {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transform: scale(1.02);
    border: 2px solid #ffffff80;
    cursor: pointer;
}

.widget-stats {
    transition: all 0.3s ease;
}

  </style>
@endpush
@push('scripts')
	<script src="/assets/plugins/d3/d3.min.js"></script>
	<script src="/assets/plugins/nvd3/build/nv.d3.js"></script>
	<script src="/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
	<script src="/assets/plugins/jvectormap-content/world-mill.js"></script>
	
	<script src="/assets/plugins/gritter/js/jquery.gritter.js"></script>
	<script src="/assets/js/demo/dashboard-v2.js"></script>
	<script>
		var userName = "{{ Auth::user()->full_name }}"; // Get Laravel user name
		var first = userName.split(" ")[0];
		$(document).ready(function() {
			
			DashboardV2.init(first);
			console.log(userName);
		});
	</script>
	
@endpush

@section('content')
	<!-- BEGIN breadcrumb -->
	
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h1 class="page-header mb-0" style="color:#073766;">Lawyer Dashboard <small style="color:#2b3131; font-size: 60%; display: inline-block; margin-left: 10px;">Case Management and Tracking Made Easier</small></h1>

	  </div>
	<!-- END page-header -->
	<!-- BEGIN row -->
<div class="row">
		<!-- BEGIN col-3 -->
<div class="col-xl-4 col-md-6">
    <a href="{{ route('cases.index', ['filter' => 'closed_lawyer']) }}" class="widget-link">
        <div class="widget widget-stats bg-teal">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-balance-scale fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title">MY CLOSED CASES</div>
                <div class="stats-number">{{ $closedCases }}</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" style="width: {{ $closedCases > 0 ? round(($wonCases / $closedCases) * 100) : 0 }}%;"></div>
                </div>
                <div class="stats-desc">
                    Won: {{ $wonCases }} | Lost: {{ $lostCases }}
                </div>
            </div>
        </div>
    </a>
</div>



		
	<div class="col-xl-4 col-md-6">
    <a href="{{ route('cases.index', ['filter' => 'my_active_cases']) }}" class="widget-link">
        <div class="widget widget-stats bg-blue">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-briefcase fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title">MY ACTIVE CASES</div>
                <div class="stats-number" id="active-cases-count">...</div>
                <div class="stats-progress progress">
                    <div class="progress-bar" id="active-cases-bar" style="width: 0%;"></div>
                </div>
                <div class="stats-desc" id="active-cases-trend">Loading...</div>
            </div>
        </div>
    </a>
</div>

		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
	<div class="col-xl-4 col-md-6">
    <a href="{{ route('cases.index', ['filter' => 'upcoming_hearings']) }}" class="widget-link">
        <div class="widget widget-stats bg-indigo">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-calendar-alt fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title">MY UPCOMING HEARINGS</div>
                <div id="upcoming-hearings-number" class="stats-number">0</div>
                <div class="stats-progress progress">
                    <div id="upcoming-hearings-bar" class="progress-bar" style="width: 0%;"></div>
                </div>
                <div id="upcoming-hearings-desc" class="stats-desc">Click to view</div>
            </div>
        </div>
    </a>
</div>


		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		
		

		<!-- END col-3 -->
	
		
</div>

<div class="row mt-5">
		<!-- BEGIN col-3 -->
		<div class="col-xl-4 col-md-6"> 
	<div class="widget widget-stats bg-purple" id="complianceWidget">
		<div class="stats-icon stats-icon-lg">
			<i class="fa fa-user-shield fa-fw"></i>
		</div>
		<div class="stats-content">
			<div class="stats-title">PROFILE AND COMPLIANCE</div>
			<div class="stats-number text-white" id="compliance-status">Status</div>
			
			<!-- Add this progress bar to match height with others -->
			<div class="stats-progress progress">
				<div class="progress-bar bg-white" style="width: 100%; opacity: 0;"></div>
			</div>

			<div class="stats-desc" id="compliance-desc">
				<small class="text-muted">Loading compliance info...</small>
			</div>
		</div>
	</div>
</div>



		
		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
<div class="col-xl-4 col-md-6">
    <a href="{{ route('lawyers.my_index') }}" class="widget-link">
        <div class="widget widget-stats bg-pink">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-folder-plus fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title">CASE ASSIGNMENTS</div>
                <div id="new-cases-number" class="stats-number">0</div>
                <div class="stats-progress progress">
                    <div id="new-cases-bar" class="progress-bar" style="width: 0%;"></div>
                </div>
                <div id="new-cases-desc" class="stats-desc">Loading...</div>
            </div>
        </div>
    </a>
</div>


		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
<div class="col-xl-4 col-md-6">
    <a href="{{ route('cases.index', ['filter' => 'awaiting_evaluation']) }}" class="widget-link">
        <div class="widget widget-stats bg-orange">
            <div class="stats-icon stats-icon-lg"><i class="fa fa-hourglass-half fa-fw"></i></div>
            <div class="stats-content">
                <div class="stats-title">CASES AWAITING EVALUATION</div>
                <div id="awaiting-cases-number" class="stats-number">0</div>
                <div class="stats-progress progress">
                    <div id="awaiting-cases-bar" class="progress-bar" style="width: 0%;"></div>
                </div>
                <div id="awaiting-cases-desc" class="stats-desc">Click to view</div>
            </div>
        </div>
    </a>
</div>

		

		<!-- END col-3 -->
	</div>

	<div class="row mt-4">
    <!-- Total Payments -->
    <div class="col-xl-4 col-md-6">
        <a href="{{ route('lawyer_payments.index', ['filter' => 'total']) }}" class="widget-link">
            <div class="widget widget-stats bg-primary">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-wallet fa-fw"></i></div>
                <div class="stats-content">
                    <div class="stats-title">TOTAL PAYMENTS</div>
                    <div id="total-payments-number" class="stats-number">₦0.00</div>
                    <div class="stats-progress progress">
                        <div id="total-payments-bar" class="progress-bar" style="width: 100%;"></div>
                    </div>
                    <div id="total-payments-desc" class="stats-desc">Both Pending and Completed payments</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Pending Payments -->
    <div class="col-xl-4 col-md-6">
        <a href="{{ route('lawyer_payments.index', ['filter' => 'pending']) }}" class="widget-link">
            <div class="widget widget-stats bg-warning">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-clock fa-fw"></i></div>
                <div class="stats-content">
                    <div class="stats-title">PENDING PAYMENTS</div>
                    <div id="pending-payments-number" class="stats-number">₦0.00</div>
                    <div class="stats-progress progress">
                        <div id="pending-payments-bar" class="progress-bar" style="width: 0%;"></div>
                    </div>
                    <div id="pending-payments-desc" class="stats-desc">Awaiting confirmation</div>
                </div>
            </div>
        </a>
    </div>

    <!-- Completed Payments -->
    <div class="col-xl-4 col-md-6">
        <a href="{{ route('lawyer_payments.index', ['filter' => 'completed']) }}" class="widget-link">
            <div class="widget widget-stats bg-success">
                <div class="stats-icon stats-icon-lg"><i class="fa fa-check-circle fa-fw"></i></div>
                <div class="stats-content">
                    <div class="stats-title">COMPLETED PAYMENTS</div>
                    <div id="completed-payments-number" class="stats-number">₦0.00</div>
                    <div class="stats-progress progress">
                        <div id="completed-payments-bar" class="progress-bar" style="width: 100%;"></div>
                    </div>
                    <div id="completed-payments-desc" class="stats-desc">Fully settled transactions</div>
                </div>
            </div>
        </a>
    </div>
</div>

		
</div>





		<!-- END col-4 -->
	
	<!-- END row -->


	<!-- Modal for showing case names -->
<!-- Modal for showing case names -->
<div class="modal fade" id="lawyerCasesModal" tabindex="-1" aria-labelledby="lawyerCasesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="lawyerCasesModalLabel">Cases Assigned to Lawyer</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		  <ul id="lawyer-cases-list">
			<!-- Cases will be dynamically inserted here -->
		  </ul>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
</div>
  

<!-- Modal for full lawyer list -->
<div class="modal fade" id="allLawyersModal" tabindex="-1" aria-labelledby="allLawyersModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="allLawyersModalLabel">All Lawyers - Case Distribution</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		  <table class="table table-sm table-borderless text-white mb-0">
			<thead class="text-muted fs-11px text-uppercase border-bottom border-gray-700">
			  <tr>
				<th>Lawyer</th>
				<th class="text-end">Cases</th>
			  </tr>
			</thead>
			<tbody id="all-lawyer-case-table">
			  <tr>
				<td colspan="2" class="text-center text-muted">Loading...</td>
			  </tr>
			</tbody>
		  </table>
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	  </div>
	</div>
  </div>
  

  <div class="modal fade" id="caseStatusModal" tabindex="-1" aria-labelledby="caseStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow-lg rounded-4">
      
	<div class="modal-header text-white rounded-top-4" id="caseStatusModalHeader">
        <h5 class="modal-title" id="caseStatusModalLabel">Cases by Status</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body p-4" style="max-height: 400px; overflow-y: auto;">
        <ul id="case-status-list" class="list-group list-group-flush">
          <!-- Case names will be inserted here -->
        </ul>
      </div>
      
      <div class="modal-footer bg-light rounded-bottom-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

  
@endsection



@push('scripts')
<!-- Script for Apex Chart -->
<script>



document.addEventListener("DOMContentLoaded", function () {
  fetch("{{ route('cases.status.data') }}")
    .then(response => response.json())
    .then(data => {
      const statuses = data.map(item => item.case_status);
      const counts = data.map(item => item.total);

      const colors = [
        '#f39c12', '#e74c3c', '#8e44ad', '#3498db', '#1abc9c', '#2ecc71',
        '#34495e', '#d35400', '#c0392b', '#2980b9', '#27ae60', '#7f8c8d',
        '#9b59b6', '#95a5a6'
      ];

      const options = {
        chart: {
          height: 500,
          type: 'bar',
          toolbar: { show: false }
        },
        plotOptions: {
          bar: {
            horizontal: true,
            distributed: true,
            dataLabels: { position: 'top' }
          }
        },		
chart: {
  height: 500,
  type: 'bar',
  toolbar: { show: false },
  events: {
	dataPointSelection: function(event, chartContext, config) {
  const status = config.w.config.xaxis.categories[config.dataPointIndex];
  const barColor = config.w.config.colors[config.dataPointIndex];

  // Apply color to modal header
  const header = document.getElementById('caseStatusModalHeader');
  header.style.backgroundColor = barColor;

  // Change modal title
  document.getElementById('caseStatusModalLabel').textContent = `Cases with Status: ${status}`;

  // Fetch and display case list
  fetch("{{ route('cases.by.status', ':status') }}".replace(':status', encodeURIComponent(status)))
    .then(response => response.json())
    .then(data => {
      const list = document.getElementById('case-status-list');
      list.innerHTML = '';

      if (data.length === 0) {
        list.innerHTML = '<li class="list-group-item">No cases with this status</li>';
      } else {
        data.forEach(caseName => {
          const li = document.createElement('li');
          li.classList.add('list-group-item');
          li.textContent = caseName;
          list.appendChild(li);
        });
      }

      const modal = new bootstrap.Modal(document.getElementById('caseStatusModal'));
      modal.show();
    })
    .catch(error => {
      console.error('Error fetching case list:', error);
    });
}
 }
},
        dataLabels: {
          enabled: true,
          offsetX: -6
        },
        colors: colors,
        series: [{
          name: 'Number of Cases',
          data: counts
        }],
        xaxis: {
          categories: statuses,
          labels: { style: { colors: '#ffffff' } }
        },
        yaxis: {
          labels: { style: { colors: '#ffffff' } }
        },
        grid: {
          borderColor: '#444'
        },
        tooltip: {
          theme: 'dark'
        },
        legend: {
          show: false
        }
      };

      new ApexCharts(document.querySelector('#case-status-bar-chart'), options).render();
    })
    .catch(error => console.error('Error fetching case status data:', error));
});
  </script>


<script>
	document.addEventListener("DOMContentLoaded", function () {
	  const labels = ['John Doe', 'Jane Smith', 'Alice Johnson', 'Bob Brown', 'Samuel Lee'];
	  const seriesData = [15, 22, 8, 18, 10];
	  const colors = ['#f39c12', '#e74c3c', '#8e44ad', '#3498db', '#1abc9c'];
	
	  const options = {
		chart: {
		  type: 'bar',
		  height: 400,
		  toolbar: { show: false }
		},
		plotOptions: {
		  bar: {
			horizontal: true,
			distributed: true,
			dataLabels: { position: 'top' }
		  }
		},
		dataLabels: {
		  enabled: true,
		  offsetX: -6,
		  style: { colors: ['#fff'] }
		},
		colors: colors,
		series: [{
		  data: seriesData
		}],
		xaxis: {
		  categories: labels,
		  labels: { style: { colors: '#fff' } }
		},
		yaxis: {
		  labels: { style: { colors: '#fff' } }
		},
		tooltip: {
		  theme: 'dark',
		  y: {
			formatter: function (val) {
			  return `${val} Cases`;
			}
		  }
		},
		grid: {
		  borderColor: '#444'
		},
		legend: { show: false }
	  };
	
	  const chart = new ApexCharts(document.querySelector("#lawyer-bar-chart"), options);
	  chart.render();
	});


document.addEventListener('DOMContentLoaded', function () {
    fetch("{{ route('lawyer.case.distribution') }}")
      .then(response => response.json())
      .then(data => {
        const tableBody = document.getElementById('lawyer-case-table');
        tableBody.innerHTML = '';

        if (data.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">No data available</td></tr>';
          return;
        }

        // Add the loading row (initially hidden)
        const loadingRow = document.createElement('tr');
        loadingRow.id = 'loading-row';
        loadingRow.style.display = 'none';
        loadingRow.innerHTML = `
          <td colspan="2" class="text-center text-muted">Loading...</td>
        `;
        tableBody.appendChild(loadingRow);

        // Populate lawyer rows
        data.forEach(lawyer => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${lawyer.full_name}</td>
            <td class="text-end"> 
              <button type="button" class="btn btn-info view-cases" data-lawyer-id="${lawyer.lawyer_id}"
			   data-lawyer-name="${lawyer.full_name}"
			  >${lawyer.total_cases}</button>
            </td>
          `;
          tableBody.appendChild(row);
        });
      })
      .catch(error => {
        console.error("Error loading lawyer case data:", error);
        document.getElementById('lawyer-case-table').innerHTML =
          '<tr><td colspan="2" class="text-center text-danger">Failed to load data</td></tr>';
      });

    // Delegate button click handling for "view-cases"
    const tableBody = document.getElementById('lawyer-case-table');

    tableBody.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('view-cases')) {
            const lawyerId = e.target.getAttribute('data-lawyer-id');
			const lawyerName = e.target.getAttribute('data-lawyer-name');
			document.getElementById('lawyerCasesModalLabel').textContent = `Cases Assigned to ${lawyerName}`;


            const url = `{{ route('cases.by.lawyer', ':lawyerId') }}`.replace(':lawyerId', lawyerId);

            const loadingRow = document.getElementById('loading-row');
            if (loadingRow) loadingRow.style.display = 'table-row';

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const caseList = document.getElementById('lawyer-cases-list');
                    caseList.innerHTML = '';
                    if (loadingRow) loadingRow.style.display = 'none';

                    if (data.length === 0) {
                        caseList.innerHTML = '<li>No cases assigned</li>';
                    } else {
                        data.forEach(function (caseName) {
                            const listItem = document.createElement('li');
                            listItem.textContent = caseName;
                            caseList.appendChild(listItem);
                        });
                    }

                    const modal = new bootstrap.Modal(document.getElementById('lawyerCasesModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching cases:', error);
                    if (loadingRow) loadingRow.style.display = 'none';
                    const caseList = document.getElementById('lawyer-cases-list');
                    caseList.innerHTML = '<li>There was an error loading cases</li>';
                });
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('viewAllLawyersBtn').addEventListener('click', function () {
    const tableBody = document.getElementById('all-lawyer-case-table');
    tableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">Loading...</td></tr>';

    fetch("{{ route('lawyer.case.distribution.all') }}") // Create this route
      .then(response => response.json())
      .then(data => {
        tableBody.innerHTML = '';

        if (data.length === 0) {
          tableBody.innerHTML = '<tr><td colspan="2" class="text-center text-muted">No data available</td></tr>';
          return;
        }

        data.forEach(lawyer => {
          const row = document.createElement('tr');
		  
          row.innerHTML = `
            <td>${lawyer.full_name}</td>
            <td class="text-end">
			 <button type="button" class="btn btn-info view-cases" data-lawyer-id="${lawyer.lawyer_id}"
			   data-lawyer-name="${lawyer.full_name}"
			  >${lawyer.total_cases}</button>	
			</td>
          `;
          tableBody.appendChild(row);
        });

        const modal = new bootstrap.Modal(document.getElementById('allLawyersModal'));
        modal.show();
      })
      .catch(error => {
        console.error("Error loading all lawyer data:", error);
        tableBody.innerHTML = '<tr><td colspan="2" class="text-center text-danger">Failed to load data</td></tr>';
      });
  });


  // Delegate button click handling for "view-cases"
  const tableBody = document.getElementById('all-lawyer-case-table');

tableBody.addEventListener('click', function (e) {
	if (e.target && e.target.classList.contains('view-cases')) {
		const lawyerId = e.target.getAttribute('data-lawyer-id');
		const lawyerName = e.target.getAttribute('data-lawyer-name');
		document.getElementById('lawyerCasesModalLabel').textContent = `Cases Assigned to ${lawyerName}`;


		const url = `{{ route('cases.by.lawyer', ':lawyerId') }}`.replace(':lawyerId', lawyerId);

		const loadingRow = document.getElementById('loading-row');
		if (loadingRow) loadingRow.style.display = 'table-row';

		fetch(url)
			.then(response => response.json())
			.then(data => {
				const caseList = document.getElementById('lawyer-cases-list');
				caseList.innerHTML = '';
				if (loadingRow) loadingRow.style.display = 'none';

				if (data.length === 0) {
					caseList.innerHTML = '<li>No cases assigned</li>';
				} else {
					data.forEach(function (caseName) {
						const listItem = document.createElement('li');
						listItem.textContent = caseName;
						caseList.appendChild(listItem);
					});
				}

				const allLawyersModalEl = document.getElementById('allLawyersModal');
				const lawyerCasesModalEl = document.getElementById('lawyerCasesModal');

// Get instance of already-shown modal
			const allLawyersModalInstance = bootstrap.Modal.getInstance(allLawyersModalEl);
			const lawyerCasesModalInstance = new bootstrap.Modal(lawyerCasesModalEl);

			// Hide the currently open modal (if any)
			if (allLawyersModalInstance) {
				allLawyersModalInstance.hide();
			}

			// Show the target modal
			lawyerCasesModalInstance.show();

			})
			.catch(error => {
				console.error('Error fetching cases:', error);
				if (loadingRow) loadingRow.style.display = 'none';
				const caseList = document.getElementById('lawyer-cases-list');
				caseList.innerHTML = '<li>There was an error loading cases</li>';
			});
	}
});

});
	</script>


<script>
	document.addEventListener("DOMContentLoaded", function () {
		fetchUpcomingDates();
	
		function fetchUpcomingDates() {
			fetch("{{ route('dashboard.upcoming-dates') }}")
				.then(response => response.json())
				.then(data => {
					const listContainer = document.getElementById('upcoming-dates-list');
					listContainer.innerHTML = ''; // Clear old items
	
					if (Array.isArray(data) && data.length > 0) {
						data.forEach(item => {

							
							const listItem = document.createElement('a');
							listItem.href = "javascript:;";
							listItem.className = "list-group-item list-group-item-action d-flex align-items-center";
	
							const contentDiv = document.createElement('div');
							contentDiv.className = "flex-fill";
	
							const titleDiv = document.createElement('div');
							titleDiv.className = "fw-bold";
							titleDiv.textContent = `${item.type} - ${item.description}`;
	
							const dateSmall = document.createElement('small');
							dateSmall.className = "text-muted";
							const date = new Date(item.datetime);
							const formattedDate = date.toLocaleString('en-US', {
								month: 'short',
								day: 'numeric',
								year: 'numeric',
								hour: 'numeric',
								minute: '2-digit',
								hour12: true
							});
							dateSmall.innerHTML = `<i class="far fa-clock me-1"></i>${formattedDate}`;
	
							contentDiv.appendChild(titleDiv);
							contentDiv.appendChild(dateSmall);
	
							const badgeSpan = document.createElement('span');
							badgeSpan.className = "badge text-white ms-2";
							badgeSpan.style.backgroundColor = item.badge_color;
							
							badgeSpan.textContent = item.type;
	
							listItem.appendChild(contentDiv);
							listItem.appendChild(badgeSpan);
	
							listContainer.appendChild(listItem);
						});
					} else {
						const emptyItem = document.createElement('div');
						emptyItem.className = "list-group-item text-muted";
						emptyItem.textContent = "No upcoming events.";
						listContainer.appendChild(emptyItem);
					}
				})
				.catch(error => {
					console.error("Error fetching upcoming dates:", error);
				});
		}
	});
</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		fetch("{{ route('stats.active.cases') }}")
			.then(response => response.json())
			.then(data => {
				if (data.count !== undefined && data.trend !== undefined) {
					document.getElementById('active-cases-count').textContent = data.count;
	
					const match = data.trend.match(/\((\d+)%\)/);
					const percentage = match ? parseInt(match[1]) : 0;
	
					document.getElementById('active-cases-bar').style.width = percentage + '%';
					document.getElementById('active-cases-trend').textContent = data.trend;
				}
			})
			.catch(error => {
				console.error('Error fetching active case stats:', error);
				document.getElementById('active-cases-trend').textContent = 'Error loading data';
			});
	});
</script>
	
<script>
	document.addEventListener("DOMContentLoaded", function () {
		fetch("{{ route('stats.upcoming.hearings') }}")
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					console.error("Error:", data.error);
					return;
				}
	
				const numberEl = document.getElementById("upcoming-hearings-number");
				const barEl = document.getElementById("upcoming-hearings-bar");
				const descEl = document.getElementById("upcoming-hearings-desc");
	
				numberEl.textContent = data.count;
				barEl.style.width = data.change + "%";
				descEl.textContent = `${data.trend} from last month (${data.change}%)`;
			})
			.catch(error => console.error("Failed to fetch upcoming hearings stats:", error));
	});
	</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		fetch("{{ route('stats.new.cases') }}")
			.then(response => response.json())
			.then(data => {
				if (data.error) {
					console.error("Error:", data.error);
					return;
				}
	
				document.getElementById("new-cases-number").textContent = data.count;
				document.getElementById("new-cases-bar").style.width = data.change + "%";
				document.getElementById("new-cases-desc").textContent = `${data.trend} from last month (${data.change}%)`;
			})
			.catch(error => console.error("Failed to fetch new cases stats:", error));
	});
	</script>
	
	<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route("lawyer.compliance.stats") }}')
        .then(response => response.json())
        .then(data => {
            const widget = document.querySelector('#complianceWidget .stats-desc');
            const numberLabel = document.querySelector('#complianceWidget .stats-number');

            if (data.compliant) {
                numberLabel.textContent = 'Compliant';
                widget.innerHTML = `<span class="text-success">All compliance checks passed.</span>`;
            } else {
                numberLabel.textContent = 'Issues';
                widget.innerHTML = `<ul class="text-danger mb-0">${data.issues.map(issue => `<li>${issue}</li>`).join('')}</ul>`;
            }
        })
        .catch(error => {
            console.error('Error loading compliance data:', error);
            const widget = document.querySelector('#complianceWidget .stats-desc');
            widget.innerHTML = `<span class="text-warning">Error fetching compliance data.</span>`;
        });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route("lawyer.cases.awaiting.actions") }}')
        .then(response => response.json())
        .then(data => {
            const count = data.count || 0;
            document.getElementById('awaiting-cases-number').innerText = count;
            document.getElementById('awaiting-cases-bar').style.width = Math.min(count * 10, 100) + '%';
            document.getElementById('awaiting-cases-desc').innerText = count > 0 
                ? 'You have cases pending evaluation'
                : 'All evaluations submitted';
        })
        .catch(error => {
            console.error('Error loading awaiting cases:', error);
            document.getElementById('awaiting-cases-desc').innerText = 'Error loading data';
        });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch("{{ route('stats.payments') }}")
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById('total-payments-number').textContent = 'KSH.' + data.total.toLocaleString();
                document.getElementById('pending-payments-number').textContent = 'KSH' + data.pending.toLocaleString();
                document.getElementById('completed-payments-number').textContent = 'KSH' + data.completed.toLocaleString();

                const total = data.total || 1; // Avoid division by zero
                document.getElementById('pending-payments-bar').style.width = ((data.pending / total) * 100).toFixed(0) + '%';
                document.getElementById('completed-payments-bar').style.width = ((data.completed / total) * 100).toFixed(0) + '%';
            }
        })
        .catch(error => {
            console.error('Error fetching payment stats:', error);
        });
});
</script>



@endpush