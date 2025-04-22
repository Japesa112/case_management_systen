<?php

return [
    'menu' => [
        [
            'icon' => 'fa fa-tachometer-alt',
            'title' => 'Dashboard',
            'url' => '/dashboard/lawyer',
            'route-name' => 'lawyer-dashboard'
        ],
        [
            'icon' => 'fa fa-list-alt',
            'title' => 'Cases List',
            'url' => '/cases',
            'route-name' => 'lawyer-cases'
        ],
        [
            'icon' => 'fa fa-folder',
            'title' => 'My Assigned Cases',
            'url' => '/lawyers/my-cases',
            'route-name' => 'assigned-cases'
        ],
        [
            'icon' => 'fa-solid fa-balance-scale',
            'title' => 'My Evaluated Cases',
            'url' => '/evaluations',
            'route-name' => 'assigned-cases'
        ],

        
        [
            'icon' => 'fa fa-calendar-alt',
            'title' => 'Hearing Schedule',
            'url' => '/calendar',
		    'route-name' => 'calendar'
        ],
        
      
        [
            'icon' => 'fa fa-credit-card',
            'title' => 'Billing & Invoices',
            'url' => '/lawyer_payments',
            'route-name' => 'lawyer-billing'
        ],
        
    ]
];

