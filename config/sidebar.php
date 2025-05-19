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
			'url' => '/cases',
			'icon' => 'fa-solid fa-briefcase', // Case-related icon
			'title' => 'Case Management',
			'caret' => true,
			'sub_menu' => [
				[
					'url' => '/cases/add',
					'title' => 'Add New Case',
					'icon' => 'fa-solid fa-folder-plus', // Icon for adding cases
					'route-names' => ['cases.create'],
					'permission' => 'create-case'
				],
				
				[
					'url' => '/cases/matter',
					'title' => 'Hearings/Mentions',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-names' => ['cases.matter', 'cases.addHearing', 'cases.addMention', 'cases.updateMatter'],
					
				],
				[
					'url' => '/cases',
					'title' => 'View All Cases',
					'icon' => 'fa-solid fa-list', // Icon for listing cases
					'route-names' => ['cases.index', 'cases.show', 'cases.panelEvaluation', 'cases.sendEmail'],
					'permission' => 'view-case'
				]
			]
		],
		[
			'url' => '/negotiations',
			'title' => 'Negotiations',
			'icon' => 'fa-solid fa-folder-open', // Icon for editing cases
			'route-prefix' => 'negotiations.',
			'permission' => 'edit-case'
		],
		[
			'icon' => 'fa-solid fa-balance-scale', // Case-related icon
			'title' => 'Panel Evaluation',
			'url' => '/evaluations',
			
			'route-prefix' => 'evaluations.',
				
			
		],

				[
					'url' => '/ag_advice',
					'title' => 'Ag Advice',
					'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
					'route-prefix' => 'ag_advice.',
					
				],
				[
					'url' => '/dvc_appointments',
					'title' => 'DVC Appointments',
					'icon' => 'fa-solid fa-user-clock', // Icon for deleting cases
					'caret' => true,
					'sub_menu' => [
				
							[
								'url' => '/dvc_appointments',
								'title' => 'Forwardings',
								'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
								'route-prefix' => 'dvc_appointments.',
								
							],
							[
								'url' => '/dvc',
								'title' => 'Appointments',
								'icon' => 'fa-solid fa-folder-minus', // Icon for deleting cases
								 'route-prefix' => 'dvc.',
								
							],

				
			]
					
				],

		[
			'icon' => 'fas fa-money-check-alt',
			'title' => 'Payment Management',
			'url' => 'javascript:;',
			'caret' => true,
			'sub_menu' => [
				[
					'url' => '/all_payments',
					'title' => 'All Payments',
					'icon' => 'fa-solid fa-folder-minus',
					'route-prefix' => 'all_payments.', // 👈 USE PREFIX
				],
				[
					'url' => '/lawyer_payments',
					'title' => 'Lawyer Payments',
					'icon' => 'fa-solid fa-folder-minus',
					'route-prefix' => 'lawyer_payments.', // 👈 USE PREFIX
				],
			]
		],

		

		







		
		

		[
	'icon' => 'fas fa-landmark',
	'title' => 'Court Trials',
	'url' => 'javascript:;',
	'caret' => true,
	'sub_menu' => [

		[
			'icon' => 'fas fa-microphone-alt',
			'title' => 'All Trials',
			'url' => '/trials',
			'route-prefix' => 'trials.'
		],
		[
			'icon' => 'fas fa-microphone-alt',
			'title' => 'Trials Preparations',
			'url' => '/preparations',
			'route-prefix' => 'preparations.'
		],
		[
			'icon' => 'fas fa-microphone-alt',
			'title' => 'Witnesses',
			'url' => '/witnesses',
			'route-prefix' => 'witnesses.'
		],
		[
			'icon' => 'fas fa-sync',
			'title' => 'Appeals',
			'url' => '/appeals',
			'route-prefix' => 'appeals.'
		],
		[
			'icon' => 'fas fa-pause-circle',
			'title' => 'Adjourns',
			'url' => '/adjourns',
			'route-prefix' => 'adjourns.'
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
