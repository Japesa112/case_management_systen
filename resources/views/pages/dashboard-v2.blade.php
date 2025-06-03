@extends('layouts.default')

@section('title', 'Dashboard')

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


	.chartBox {
  padding: 20px;
  border-radius: 20px;
  border: solid 5px rgba(255, 26, 104,1);
  background: white;

}

.chartWrapper > canvas {
  position: absolute;
  left: 0;
  top: 0;
  pointer-events: none;
}

.container {
  max-height: 400px;       /* Defines vertical limit */
  overflow-y: auto;        /* Enables vertical scroll if content exceeds height */
  overflow-x: hidden;      /* Prevents unwanted horizontal scroll */
  direction: rtl;
}

.containerBody {
  height: auto;            /* Let JS control this dynamically */
  width: 100%;             /* Chart fills container horizontally */
   direction: ltr;
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
		<h1 class="page-header mb-0" style="color:#073766;">Admin Dashboard <small style="color:#2b3131; font-size: 60%; display: inline-block; margin-left: 10px;">Case Management and Tracking Made Easier</small></h1>

	  </div>
	<!-- END page-header -->
	<!-- BEGIN row -->
	<div class="row">
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
		<div class="widget widget-stats bg-teal">
		<div class="stats-icon stats-icon-lg"><i class="fa fa-balance-scale fa-fw"></i></div>
		<div class="stats-content">
		<div class="stats-title">CLOSED CASES</div>
		 <a href="{{ url('/closed_cases') }}" class="btn btn-sm btn-info mb-4">
		<div class="stats-number">
   
        {{ $closedCases }}
    
		</div>
		</a>
		<div class="stats-progress progress">
			<div class="progress-bar" style="width: {{ $closedCases > 0 ? round(($wonCases / $closedCases) * 100) : 0 }}%;"></div>
		</div>
		<div class="stats-desc">
			Won: {{ $wonCases }} | Lost: {{ $lostCases }}
		</div>
		</div>
	</div>
	</div>


		
		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
		<div class="widget widget-stats bg-blue">
			<div class="stats-icon stats-icon-lg"><i class="fa fa-briefcase fa-fw"></i></div>
			<div class="stats-content">
			<div class="stats-title">ACTIVE CASES</div>
			<a href="{{ url('/cases?status=active') }}" class="btn btn-sm btn-info mb-4">

				<div class="stats-number" id="active-cases-count">...</div>
			</a>

			
			<div class="stats-progress progress">
				<div class="progress-bar" id="active-cases-bar" style="width: 0%;"></div>
			</div>
			<div class="stats-desc" id="active-cases-trend">Loading...</div>
			</div>
		</div>
		</div>

		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-indigo">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-calendar-alt fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">UPCOMING HEARINGS</div>

					<a href="{{ url('/cases?filter=upcoming_hearings') }}" class="btn btn-sm btn-info mb-4" >

					<div id="upcoming-hearings-number" class="stats-number">0</div>

				</a>
					<div class="stats-progress progress">
						<div id="upcoming-hearings-bar" class="progress-bar" style="width: 0%;"></div>
					</div>
					<div id="upcoming-hearings-desc" class="stats-desc">Loading...</div>
				</div>
			</div>
		</div>
		

		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-success">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-folder-plus fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">NEW CASES</div>
					<a href="{{ url('/cases?filter=this_month') }}" class="btn btn-sm btn-info mb-4">
					<div id="new-cases-number" class="stats-number">0</div>
				</a>
					<div class="stats-progress progress">
						<div id="new-cases-bar" class="progress-bar" style="width: 0%;"></div>
					</div>
					<div id="new-cases-desc" class="stats-desc">Loading...</div>
				</div>
			</div>
		</div>
		

		<!-- END col-3 -->
	</div>
	<!-- END row -->
	<!-- BEGIN row -->
	<div class="row">
		<!-- BEGIN col-8 -->
		<div class="col-xl-8">
			<div class="widget-chart with-sidebar" data-bs-theme="dark">
			  <div class="widget-chart-content bg-gray-800">
				<h4 class="chart-title">
				  Case Status Analytics
				  <small>Distribution of Cases by Status</small>
				</h4>
				<!-- Insert Chart Here -->
				<div id="case-status-bar-chart" class="widget-chart-full-width dark-mode" style="height: 500px;"></div>
			  </div>
			  <div class="widget-chart-sidebar bg-indigo-900" style="width: 300px">
				<h4 class="chart-title">
					Case Assignment Summary
					<br/>
					<small>Distribution of Cases by Lawyers</small>
				  </h4>
				  <table class="table table-sm table-borderless text-white mb-0">
					<thead class="text-muted fs-11px text-uppercase border-bottom border-gray-700">
					  <tr>
						<th>Lawyer</th>
						<th class="text-end">Cases</th>
					  </tr>
					</thead>
					<tbody id="lawyer-case-table">
						<tr id="loading-row">
						  <td colspan="2" class="text-center text-muted">Loading...</td>
						</tr>
						
						<!-- Add more rows dynamically -->
					  </tbody>
					  
					  
				  </table>

				  <div class="text-end mt-3">
					<button type="button" id="viewAllLawyersBtn" class="btn btn-secondary">
						All Lawyers - Case Distribution
					</button>
				  </div>
				  
			  </div>
			</div>
		  </div>
		  
		<!-- END col-8 -->
		<!-- BEGIN col-4 -->
		<div class="col-xl-4"> 
	<div class="panel panel-inverse" data-sortable-id="upcoming-events">
		<div class="panel-heading">
			<h4 class="panel-title">
				<i class="fa fa-calendar-alt me-2"></i>Upcoming Dates & Times
			</h4>
		</div>
		<div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
			
			<!-- Add more dynamically -->
			<div class="list-group list-group-flush" id="upcoming-dates-list">
				<!-- JS will populate here -->
			</div>
			
		</div>
	</div>
</div>

		<!-- END col-4 -->
	</div>
	<!-- END row -->

		<div class="row mt-4">

		   <!-- Total Payments -->
<!-- Total Payments -->
<div class="col-xl-3 col-md-6 mb-4">
  <a href="{{ url('/all_payments') }}" class="text-decoration-none">
    <div class="widget widget-stats bg-dark text-white shadow rounded-lg h-100 position-relative overflow-hidden">
      <div class="stats-icon stats-icon-lg text-white"><i class="fa fa-money-bill-wave fa-fw"></i></div>
      <div class="stats-content ps-4">
        <div class="stats-title text-uppercase fs-6 text-white">Total Payments</div>
        <div id="total-payments" class="stats-number fs-3 fw-bold text-white">Loading...</div>
        <div class="stats-desc text-light">All processed payments</div>
      </div>
    </div>
  </a>
</div>

<!-- Payments to University -->
<div class="col-xl-3 col-md-6 mb-4">
  <a href="{{ url('/all_payments?filter=kenyatta_university') }}" class="text-decoration-none">
    <div class="widget widget-stats bg-purple text-white shadow rounded-lg h-100 position-relative overflow-hidden">
      <div class="stats-icon stats-icon-lg text-white"><i class="fa fa-university fa-fw"></i></div>
      <div class="stats-content ps-4">
        <div class="stats-title text-uppercase fs-6 text-white">To University</div>
        <div id="university-payments" class="stats-number fs-3 fw-bold text-white">Loading...</div>
        <div class="stats-desc text-light">Received by university</div>
      </div>
    </div>
  </a>
</div>

<!-- Payment Overdues -->
<div class="col-xl-3 col-md-6 mb-4">
  <a href="{{ url('/all_payments?filter=overdue') }}" class="text-decoration-none">
    <div class="widget widget-stats bg-danger text-white shadow rounded-lg h-100 position-relative overflow-hidden">
      <div class="stats-icon stats-icon-lg text-white"><i class="fa fa-exclamation-triangle fa-fw"></i></div>
      <div class="stats-content ps-4">
        <div class="stats-title text-uppercase fs-6 text-white">Overdue Payments</div>
        <div id="overdue-payments" class="stats-number fs-3 fw-bold text-white">Loading...</div>
        <div class="stats-desc text-light">Unsettled past due</div>
      </div>
    </div>
  </a>
</div>



		    <!-- Pie Chart: Payment Distribution -->
		    <div class="col-xl-3 col-md-6">
		        <div class="widget widget-stats bg-white text-dark">
		            <div class="stats-icon stats-icon-lg"><i class="fa fa-chart-pie fa-fw"></i></div>
		            <div class="stats-content">
		                <div class="stats-title">PAYMENT DISTRIBUTION</div>
		                <div><canvas id="paymentDistributionChart" height="100"></canvas></div>
		                <div class="stats-desc">Lawyers, Complainants, Others</div>
		            </div>
		        </div>
		    </div>

		</div>


<div class="row mb-3">
  <div class="col-md-3">
    <label>Start Date</label>
    <input type="date" id="startDate" class="form-control">
  </div>
  <div class="col-md-3">
    <label>End Date</label>
    <input type="date" id="endDate" class="form-control">
  </div>
  <div class="col-md-3">
    <label>Group By</label>
    <select id="groupBy" class="form-control">
      <option value="daily">Daily</option>
      <option value="weekly">Weekly</option>
      <option value="monthly">Monthly</option>
    </select>
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button id="filterButton" class="btn btn-primary w-100">Apply Filters</button>
  </div>
</div>


<div class="chartCard">
	<div class="chartBox">
		<div class="container">
			<div class="containerBody">
				<canvas id="paymentsBarChart"></canvas>
			</div>
		</div>
	</div>
</div>



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


<!-- Modal -->
<div class="modal fade" id="paymentsModal" tabindex="-1" aria-labelledby="paymentsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentsModalLabel">Payments</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-striped" id="paymentsTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Case Name</th>
              <th>Payee</th>
              <th>Amount</th>
              <th>Method</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>


  
@endsection



@push('scripts')
<!-- Script for Apex Chart -->
<script>



document.addEventListener("DOMContentLoaded", function () {
  fetch('/case-status-data')
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
  fetch(`/cases/by-status/${encodeURIComponent(status)}`)
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
    $.ajax({
        url: '/dashboard/payment-stats',
        type: 'GET',
        success: function (data) {
            // Update widgets
            $('#total-payments').text(data.totalPayments + ' KSH');
            $('#university-payments').text(data.universityPayments + ' KSH');
            $('#overdue-payments').text(data.overduePayments + '');

            // Create pie chart
            // Create pie chart
							const ctx = document.getElementById('paymentDistributionChart').getContext('2d');

							const paymentChart = new Chart(ctx, {
							    type: 'doughnut',
							    data: {
							        labels: ['Lawyers', 'Complainants', 'Others'],
							        datasets: [{
							            data: [
							                data.chartData.lawyers,
							                data.chartData.complainants,
							                data.chartData.others
							            ],
							            backgroundColor: ['#007bff', '#28a745', '#ffc107'],
							            borderWidth: 1
							        }]
							    },
							    options: {
							        responsive: true,
							        plugins: {
							            legend: {
							                position: 'bottom'
							            },
							            tooltip: {
							                callbacks: {
							                    label: function (context) {
							                        return context.label + ': $' + context.formattedValue;
							                    }
							                }
							            }
							        },
							        // Add click handler
							        onClick: function (evt, elements) {
							            if (elements.length > 0) {
							                const index = elements[0].index;
							                const label = this.data.labels[index];

							                // Map label to payee query
							                let payeeType = '';
							                switch (label.toLowerCase()) {
							                    case 'lawyers':
							                        payeeType = 'lawyer';
							                        break;
							                    case 'complainants':
							                        payeeType = 'complainant';
							                        break;
							                    case 'others':
							                        payeeType = 'other';
							                        break;
							                }

							                if (payeeType) {
							                    window.location.href = `/all_payments?payee=${payeeType}`;
							                }
							            }
							        }
							    }
							});



        },
        error: function () {
            console.error('Failed to fetch payment stats');
        }
    });
});






	</script>
	
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let paymentsChart;

function fetchAndRenderChart(start = '', end = '', group = 'daily') {
  fetch(`/dashboard/payment-dates?start=${start}&end=${end}&groupBy=${group}`)
    .then(res => res.json())
    .then(data => {
      const ctx = document.getElementById('paymentsBarChart').getContext('2d');

      const colors = data.labels.map(() => {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
      });

      if (paymentsChart) paymentsChart.destroy();

      paymentsChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: data.labels,
          datasets: [{
            label: 'Payments Made ($)',
            data: data.amounts,
            backgroundColor: colors,
            borderRadius: 4
          }]
        },
        options: {
          indexAxis: 'y',
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            tooltip: {
              callbacks: {
                label: ctx => `$${ctx.formattedValue}`
              }
            },
            legend: { display: false }
          },
          scales: {

            x: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Amount ($)'
              }
            },
            y: {
              ticks: {
                autoSkip: false
              }
            }
          },
          onClick: async function (evt, elements) {
						  if (elements.length > 0) {
						    const index = elements[0].index;
						    const selectedDate = data.labels[index];

						     const selectedLabel = data.labels[index]; // could be a single date or a range string
						     dayjs.extend(dayjs_plugin_customParseFormat);


						     let url = '';
									if (selectedLabel.includes(' - ')) {
									  // Date range (weekly)
									  const [startDate, endDate] = selectedLabel.split(' - ').map(s => s.trim());
									  url = `/dashboard/payments/by-date?startDate=${startDate}&endDate=${endDate}`;
									} else if (/^[A-Za-z]+ \d{4}$/.test(selectedLabel)) {
									  // Monthly format like "March 2025"
									  const startDate = dayjs(selectedLabel, "MMMM YYYY").startOf('month').format('YYYY-MM-DD');
									  const endDate = dayjs(selectedLabel, "MMMM YYYY").endOf('month').format('YYYY-MM-DD');
									  url = `/dashboard/payments/by-date?startDate=${startDate}&endDate=${endDate}`;
									} else {
									  // Assume single date (daily)
									  url = `/dashboard/payments/by-date?date=${selectedLabel}`;
									}


						    try {
						      const response = await fetch(url);
						      const payments = await response.json();
						      console.log(payments);

						      const tbody = document.querySelector('#paymentsTable tbody');
						      tbody.innerHTML = '';

						      if (payments.length === 0) {
						        tbody.innerHTML = `<tr><td colspan="5" class="text-center">No payments found for ${selectedDate}</td></tr>`;
						      } else {
						        payments.forEach((payment, idx) => {
						          const row = `
						            <tr>
						              <td>${idx + 1}</td>
						          		<td>${payment.case_name}</td>
						              <td>${payment.payee}</td>
						              <td>$${payment.amount_paid}</td>
						              <td>${payment.payment_method}</td>
						              <td>${payment.payment_status}</td>
						            </tr>`;
						          tbody.insertAdjacentHTML('beforeend', row);
						        });
						      }

						      document.getElementById('paymentsModalLabel').textContent = `Payments on ${selectedDate}`;
						      const modal = new bootstrap.Modal(document.getElementById('paymentsModal'));
						      modal.show();

						    } catch (error) {
						      console.error('Error fetching payments by date:', error);
						      alert('Could not fetch payment details.');
						    }
						  }
						}

        }
      });

	      const containerBody = document.querySelector('.containerBody');
	const totalLabels = paymentsChart.data.labels.length;

	if (totalLabels > 7) {
	  const newHeight = 300 + ((totalLabels - 7) * 40);
	  containerBody.style.height = `${newHeight}px`;
	} else {
	  containerBody.style.height = '400px';
	}
    })
    .catch(() => console.error('Failed to fetch payment data.'));


    


}

document.addEventListener('DOMContentLoaded', function () {
  fetchAndRenderChart();

  document.getElementById('filterButton').addEventListener('click', function () {
    const start = document.getElementById('startDate').value;
    const end = document.getElementById('endDate').value;
    const group = document.getElementById('groupBy').value;
    fetchAndRenderChart(start, end, group);
  });
});
</script>

	
@endpush