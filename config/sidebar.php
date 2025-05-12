<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */
  'menu' => [


		[
			'icon' => 'fa fa-sitemap',
			'url' => '/dashboard/v2',
			'title' => 'Dashboard',
			'route-name' => 'dashboard-v2',
			
		],
	
		
		[
			'icon' => 'fa-solid fa-briefcase', // Case-related icon
			'title' => 'Case Management',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [
				[
					'url' => '/cases/add',
					'title' => 'Add New Case',
					'icon' => 'fa-solid fa-folder-plus', // Icon for adding cases
					'route-name' => 'cases.add',
					'permission' => 'create-case'
				],
				
				[
					'url' => '/cases/matter',
					'title' => 'Hearings/Mentions',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-name' =>'closed_cases.index',
					
				],
				[
					'url' => '/cases',
					'title' => 'View All Cases',
					'icon' => 'fa-solid fa-list', // Icon for listing cases
					'route-name' => 'cases.view',
					'permission' => 'view-case'
				]
			]
		],
		[
			'url' => '/negotiations',
			'title' => 'Negotiations',
			'icon' => 'fa-solid fa-folder-open', // Icon for editing cases
			'route-name' => 'cases.update',
			'permission' => 'edit-case'
		],
		[
			'icon' => 'fa-solid fa-balance-scale', // Case-related icon
			'title' => 'Panel Evaluation',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [
				
				[
					'url' => '/evaluations',
					'title' => 'All Evaluations',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-name' =>'all_payments.index',
					
				]
				
			]
		],

				[
					'url' => '/ag_advice',
					'title' => 'Ag Advice',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-name' =>'lawyer_payments.index',
					
				],
				[
					'url' => '/dvc_appointments',
					'title' => 'DVC Appointments',
					'icon' => 'fa-solid fa-user-clock', // Icon for deleting cases
					'route-name' =>'lawyer_payments.index',
					'caret' => true,
					'sub_menu' => [
				
							[
								'url' => '/dvc_appointments',
								'title' => 'Forwardings',
								'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
								
								
							],
							[
								'url' => '/dvc',
								'title' => 'Appointments',
								'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
								
								
							],

				
			]
					
				],

		[
			'icon' => 'fas fa-money-check-alt', // Case-related icon
			'title' => 'Payment Management',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [
				
				[
					'url' => '/all_payments',
					'title' => 'All Payments',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-name' =>'all_payments.index',
					
				],

				[
					'url' => '/lawyer_payments',
					'title' => 'Lawyer Payments',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-name' =>'lawyer_payments.index',
					
				],
			]
		],

		

		







		
		

		[
			'icon' => 'fas fa-landmark', // Case-related icon
			'title' => 'Court Trials',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [

				[
					'icon' => 'fas fa-microphone-alt', // Case-related icon
					'title' => 'All Trials',
					'url' => '/trials',
					
				],

				[
					'icon' => 'fas fa-microphone-alt', // Case-related icon
					'title' => 'Trials Preparations',
					'url' => '/preparations',
					
				],

				[
					'icon' => 'fas fa-microphone-alt', // Case-related icon
					'title' => 'Witnesses',
					'url' => '/witnesses',
					
				],

				[
					'icon' => 'fas fa-sync', // Case-related icon
					'title' => 'Appeals',
					'url' => '/appeals',
					
				],
				[
					'icon' => 'fas fa-pause-circle', // Case-related icon
					'title' => 'Adjourns',
					'url' => '/adjourns',
					
				],
				



			]
			
		],
		
		
		[
            'icon' => 'fa fa-calendar-alt',
            'title' => 'Calender',
            'url' => '/calendar',
		    'route-name' => 'calendar'
        ],
	]
];
