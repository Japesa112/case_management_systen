<?php

return [
    'menu' => [
        [
            'icon' => 'fa fa-tachometer-alt',
            'title' => 'Dashboard',
            'url' => '/dashboard/lawyer',
            'route-name' => 'dashboard-v2-lawyer'
        ],
        [
            'icon' => 'fa fa-list-alt',
            'title' => 'Cases List',
            'url' => '/cases',
            'route-name' => 'cases.index'
        ],
        [
            'icon' => 'fa fa-folder',
            'title' => 'My Assigned Cases',
            'url' => '/lawyers/my-cases',
            'route-name' => 'lawyers.my_index'
        ],
        [
            'icon' => 'fa-solid fa-balance-scale',
            'title' => 'My Submitted Offers',
            'url' => '/evaluations',
            'route-name' => 'evaluations.index'
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
            'route-name' => 'lawyer_payments.index'
        ],
        
    ]
];

