@extends('layouts.default')

@section('title', 'Dashboard')

@push('css')
	<link href="/assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />
	<link href="/assets/plugins/datepickk/dist/datepickk.min.css" rel="stylesheet" />
	<link href="/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
	<link href="/assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
	
@endpush

@push('styles')
<style>
	.table tbody tr {
	  border-bottom: 1px solid #fff; /* White border */
	}
  
	
  </style>
@endpush
@push('scripts')
	<script src="/assets/plugins/d3/d3.min.js"></script>
	<script src="/assets/plugins/nvd3/build/nv.d3.js"></script>
	<script src="/assets/plugins/jvectormap-next/jquery-jvectormap.min.js"></script>
	<script src="/assets/plugins/jvectormap-content/world-mill.js"></script>
	<script src="/assets/plugins/datepickk/dist/datepickk.min.js"></script>
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
	<div style="margin-top: 20px">
		<ol class="breadcrumb float-xl">
			<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:;">Dashboard</a></li>
			<li class="breadcrumb-item active">Dashboard v2</li>
		</ol>
	</div>
	<!-- END breadcrumb -->
	<!-- BEGIN page-header -->
	<h1 class="page-header">Dashboard v2 <small>header small text goes here...</small></h1>
	<!-- END page-header -->
	<!-- BEGIN row -->
	<div class="row">
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-teal">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-balance-scale fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title me-5">CLOSED CASES</div>
					<div class="stats-number">{{ $closedCases }}</div>
					<div class="stats-desc">
						<span class="me-3 text-dark"><strong>Won:</strong> {{ $wonCases }}</span>
						<span class="text-white"><strong>Lost:</strong> {{ $lostCases }}</span>
					</div>
				</div>
			</div>
		</div>
		
		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-blue">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-dollar-sign fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">TODAY'S PROFIT</div>
					<div class="stats-number">180,200</div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 40.5%;"></div>
					</div>
					<div class="stats-desc">Better than last week (40.5%)</div>
				</div>
			</div>
		</div>
		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-6">
			<div class="widget widget-stats bg-indigo">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-archive fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">NEW ORDERS</div>
					<div class="stats-number">38,900</div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 76.3%;"></div>
					</div>
					<div class="stats-desc">Better than last week (76.3%)</div>
				</div>
			</div>
		</div>
		<!-- END col-3 -->
		<!-- BEGIN col-3 -->
		<div class="col-xl-3 col-md-9">
			<div class="widget widget-stats bg-gray-900">
				<div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
				<div class="stats-content">
					<div class="stats-title">NEW COMMENTS</div>
					<div class="stats-number">3,988</div>
					<div class="stats-progress progress">
						<div class="progress-bar" style="width: 54.9%;"></div>
					</div>
					<div class="stats-desc">Better than last week (54.9%)</div>
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
						<tr>
						  <td>John Doe</td>
						  <td class="text-end">
							<button type="button" class="btn btn-info view-cases" data-lawyer-id="1">10</button>
						  </td>
						</tr>
						<tr>
						  <td>Jane Smith</td>
						  <td class="text-end">
							<button type="button" class="btn btn-info view-cases" data-lawyer-id="2">5</button>
						  </td>
						</tr>
						<!-- Add more rows dynamically -->
					  </tbody>
					  
					  
				  </table>
			  </div>
			</div>
		  </div>
		  
		<!-- END col-8 -->
		<!-- BEGIN col-4 -->
		<div class="col-xl-4">
			<div class="panel panel-inverse" data-sortable-id="index-1">
				<div class="panel-heading">
					<h4 class="panel-title">
						Visitors Origin
					</h4>
				</div>
				<div id="visitors-map" class="bg-gray-900" data-bs-theme="dark" style="height: 170px;" ></div>
				<div class="list-group list-group-flush "  data-bs-theme="dark">
					<a href="javascript:;" class="list-group-item list-group-item-action d-flex">
						<span class="flex-1">1. United State</span>
						<span class="badge bg-teal fs-10px">20.95%</span>
					</a>
					<a href="javascript:;" class="list-group-item list-group-item-action d-flex">
						<span class="flex-1">2. India</span>
						<span class="badge bg-blue fs-10px">16.12%</span>
					</a>
					<a href="javascript:;" class="list-group-item list-group-item-action d-flex rounded-bottom">
						<span class="flex-1">3. Mongolia</span>
						<span class="badge bg-gray-600 fs-10px">14.99%</span>
					</a>
				</div>
			</div>
		</div>
		<!-- END col-4 -->
	</div>
	<!-- END row -->
	<!-- BEGIN row -->
	<div class="row">
		<!-- BEGIN col-4 -->
		<div class="col-xl-4 col-lg-6">
			<!-- BEGIN panel -->
			<div class="panel panel-inverse" data-sortable-id="index-2">
				<div class="panel-heading">
					<h4 class="panel-title">Chat History</h4>
					<span class="badge bg-teal">4 message</span>
				</div>
				<div class="panel-body bg-light">
					<div class="chats" data-scrollbar="true" data-height="225px">
						<div class="chats-item start">
							<span class="date-time">yesterday 11:23pm</span>
							<a href="javascript:;" class="name">Sowse Bawdy</a>
							<a href="javascript:;" class="image"><img alt="" src="/assets/img/user/user-12.jpg" /></a>
							<div class="message">
								Lorem ipsum dolor sit amet, consectetuer adipiscing elit volutpat. Praesent mattis interdum arcu eu feugiat.
							</div>
						</div>
						<div class="chats-item end">
							<span class="date-time">08:12am</span>
							<a href="javascript:;" class="name"><span class="badge bg-blue">ADMIN</span> Me</a>
							<a href="javascript:;" class="image"><img alt="" src="/assets/img/user/user-13.jpg" /></a>
							<div class="message">
								Nullam posuere, nisl a varius rhoncus, risus tellus hendrerit neque.
							</div>
						</div>
						<div class="chats-item start">
							<span class="date-time">09:20am</span>
							<a href="javascript:;" class="name">Neck Jolly</a>
							<a href="javascript:;" class="image"><img alt="" src="/assets/img/user/user-10.jpg" /></a>
							<div class="message">
								Euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.
							</div>
						</div>
						<div class="chats-item start">
							<span class="date-time">11:15am</span>
							<a href="javascript:;" class="name">Shag Strap</a>
							<a href="javascript:;" class="image"><img alt="" src="/assets/img/user/user-14.jpg" /></a>
							<div class="message">
								Nullam iaculis pharetra pharetra. Proin sodales tristique sapien mattis placerat.
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<form name="send_message_form" data-id="message-form">
						<div class="input-group">
							<input type="text" class="form-control" name="message" placeholder="Enter your message here.">
							<button class="btn btn-primary" type="button"><i class="fa fa-camera"></i></button>
							<button class="btn btn-primary" type="button"><i class="fa fa-link"></i></button>
						</div>
					</form>
				</div>
			</div>
			<!-- END panel -->
		</div>
		<!-- END col-4 -->
		<!-- BEGIN col-4 -->
		<div class="col-xl-4 col-lg-6">
			<!-- BEGIN panel -->
			<div class="panel panel-inverse" data-sortable-id="index-3">
				<div class="panel-heading">
					<h4 class="panel-title">Today's Schedule</h4>
				</div>
				<div id="schedule-calendar" class="datepickk"></div>
				<hr class="m-0 bg-gray-500" />
				<div class="list-group list-group-flush">
					<a href="javascript:;" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-ellipsis">
						Sales Reporting
						<span class="badge bg-teal fs-10px">9:00 am</span>
					</a> 
					<a href="javascript:;" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center text-ellipsis rounded-bottom">
						Have a meeting with sales team
						<span class="badge bg-blue fs-10px">2:45 pm</span>
					</a>
				</div>
			</div>
			<!-- END panel -->
		</div>
		<!-- END col-4 -->
		<!-- BEGIN col-4 -->
		<div class="col-xl-4 col-lg-6">
			<!-- BEGIN panel -->
			<div class="panel panel-inverse" data-sortable-id="index-4">
				<div class="panel-heading">
					<h4 class="panel-title">New Registered Users</h4>
					<span class="badge bg-teal">24 new users</span>
				</div>
				<ul class="registered-users-list">
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-5.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Savory Posh
							<small>Algerian</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-3.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Ancient Caviar
							<small>Korean</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-1.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Marble Lungs
							<small>Indian</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-8.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Blank Bloke
							<small>Japanese</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-2.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Hip Sculling
							<small>Cuban</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-6.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Flat Moon
							<small>Nepalese</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-4.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Packed Puffs
							<small>Malaysian</small>
						</h4>
					</li>
					<li>
						<a href="javascript:;"><img src="/assets/img/user/user-9.jpg" alt="" /></a>
						<h4 class="username text-ellipsis">
							Clay Hike
							<small>Swedish</small>
						</h4>
					</li>
				</ul>
				<div class="panel-footer text-center">
					<a href="javascript:;" class="text-decoration-none text-dark">View All</a>
				</div>
			</div>
			<!-- END panel -->
		</div>
		<!-- END col-4 -->
	</div>
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

        data.forEach(lawyer => {
		
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${lawyer.full_name}</td>
            <td class="text-end"> 
			<button type="button" class="btn btn-info view-cases" data-lawyer-id="${lawyer.lawyer_id}">${lawyer.total_cases}</button>
	
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
  });


  document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.getElementById('lawyer-case-table');
        
        tableBody.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('view-cases')) {
                const lawyerId = e.target.getAttribute('data-lawyer-id');
				alert(lawyerId);
                
                // Generate the URL for the named route
                const url = `{{ route('cases.by.lawyer', ':lawyerId') }}`.replace(':lawyerId', lawyerId);
                
                document.getElementById('loading-row').style.display = 'table-row';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const caseList = document.getElementById('lawyer-cases-list');
                        caseList.innerHTML = '';
                        document.getElementById('loading-row').style.display = 'none';

                        if (data.length === 0) {
							alert("No cases");
                            caseList.innerHTML = '<li>No cases assigned</li>';
                        } else {
                            data.forEach(function (caseName) {
								alert("Case Name is: "+caseName);
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
                        document.getElementById('loading-row').style.display = 'none';
                        const caseList = document.getElementById('lawyer-cases-list');
                        caseList.innerHTML = '<li>There was an error loading cases</li>';
                    });
            }
        });
    });

 
	</script>
@endpush