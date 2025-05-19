

@stack('styles')

@php
	$appSidebarClass = (!empty($appSidebarTransparent)) ? 'app-sidebar-transparent' : '';
	$appSidebarAttr  = (!empty($appSidebarLight)) ? '' : ' data-bs-theme=dark';
@endphp
@push('styles')
<style>
	.menu-chevron .collapse-chevron {
		transition: transform 0.3s ease;
	}
	.menu-link[aria-expanded="true"] .collapse-chevron {
		transform: rotate(90deg);
	}
</style>
@endpush

@php
		    $isUserRoute = request()->is('users') || request()->is('users/add');
		    $isLawyerRoute = request()->is('lawyers') || request()->is('lawyers/add');
		    $isProfileSectionExpanded = $isUserRoute || $isLawyerRoute;
			@endphp

<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar {{ $appSidebarClass }}" {{ $appSidebarAttr }}>
	<!-- BEGIN scrollbar -->
	<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
		<div class="menu">
			@if (!$appSidebarSearch)
			<div class="menu-profile">
				<a href="javascript:;" class="menu-profile-link {{ $isProfileSectionExpanded ? '' : 'collapsed' }}" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu" aria-expanded="{{ $isProfileSectionExpanded ? 'true' : 'false' }}">

					<div class="menu-profile-cover with-shadow"></div>
					<div class="menu-profile-image">
						<img src="/assets/img/user/user-13.jpg" alt="" />
					</div>
					<div class="menu-profile-info">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1">
								User Management
							</div>
							<div class="menu-caret ms-auto"></div>
						</div>
						<small>Admin</small>
					</div>
				</a>
			</div>


			

		<div id="appSidebarProfileMenu" class="collapse {{ $isProfileSectionExpanded ? 'show' : '' }}">

			
				
				<div class="menu-item pt-5px {{ request()->is('users') ? 'active' : '' }}">
					<a href="/users" class="menu-link">
						<div class="menu-icon"><i class="fa fa-users"></i></div>
						<div class="menu-text">All Users</div>
					</a>
				</div>
				<div class="menu-item {{ request()->is('users/add') ? 'active' : '' }}">
					<a href="/users/add" class="menu-link">
						<div class="menu-icon"><i class="fa fa-user-plus"></i></div>
						<div class="menu-text">Add User</div>
					</a>
				</div>

				


				@php
				    $isLawyerRoute = request()->is('lawyers') || request()->is('lawyers/add');
				@endphp

				<div class="menu-item {{ $isLawyerRoute ? 'active' : '' }}">
					<a href="javascript:;" class="menu-link {{ $isLawyerRoute ? '' : 'collapsed' }}" 
					   data-bs-toggle="collapse" 
					   data-bs-target="#lawyerSubMenu"
					   aria-expanded="{{ $isLawyerRoute ? 'true' : 'false' }}">
						<div class="menu-icon"><i class="fa-solid fa-gavel"></i></div>
						<div class="menu-text">Lawyer Management</div>
						<i class="collapse-chevron fa fa-chevron-down"></i>
					</a>
					<div class="sub-menu collapse {{ $isLawyerRoute ? 'show' : '' }}" id="lawyerSubMenu">
						<div class="menu-item {{ request()->is('lawyers') ? 'active' : '' }}">
							<a href="/lawyers" class="menu-link">
								<div class="menu-icon"><i class="fa-solid fa-list"></i></div>
								<div class="menu-text">View All Lawyers</div>
							</a>
						</div>
						<div class="menu-item {{ request()->is('lawyers/add') ? 'active' : '' }}">
							<a href="/lawyers/add" class="menu-link">
								<div class="menu-icon"><i class="fa-solid fa-user-plus"></i></div>
								<div class="menu-text">Add New Lawyer</div>
							</a>
						</div>
					</div>
				</div>

				
				<div class="menu-divider m-0"></div>
			</div>
			@endif
			
			@if ($appSidebarSearch)
			<div class="menu-search mb-n3">
        <input type="text" class="form-control" placeholder="Sidebar menu filter..." data-sidebar-search="true" />
			</div>
			@endif
			
			<div class="menu-header">Navigation</div>

			@php
			use Illuminate\Support\Str;

			@endphp
			
			@php
				$currentUrl = (Request::path() != '/') ? '/'. Request::path() : '/';
				
				function renderSubMenu($value, $currentUrl) {
					$subMenu = '';
					$GLOBALS['sub_level'] += 1 ;
					$GLOBALS['active'][$GLOBALS['sub_level']] = '';
					$currentLevel = $GLOBALS['sub_level'];
					foreach ($value as $key => $menu) {
						$GLOBALS['subparent_level'] = '';
						
						$subSubMenu = '';
						$hasSub = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
						$hasCaret = (!empty($menu['sub_menu'])) ? '<div class="menu-caret"></div>' : '';
						$hasHighlight = (!empty($menu['highlight'])) ? '<i class="fa fa-paper-plane text-theme ms-1"></i>' : '';
						$hasTitle = (!empty($menu['title'])) ? '<div class="menu-text">'. $menu['title'] . $hasHighlight .'</div>' : '';
						
						if (!empty($menu['sub_menu'])) {
							$subSubMenu .= '<div class="menu-submenu">';
							$subSubMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
							$subSubMenu .= '</div>';
						}
						
						$active = '';

						if (!empty($menu['route-names'])) {
							foreach ($menu['route-names'] as $routeName) {
								if (Route::currentRouteName() === $routeName) {
									$active = 'active';
									break;
								}
							}
						}

						if (!$active && !empty($menu['route-name']) && Route::currentRouteName() === $menu['route-name']) {
							$active = 'active';
						}

						if (!$active && !empty($menu['route-prefix']) && Str::startsWith(Route::currentRouteName(), $menu['route-prefix'])) {
							$active = 'active';
						}


						
						if ($active) {
							$GLOBALS['parent_active'] = true;
							$GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
						}
						if (!empty($GLOBALS['active'][$currentLevel])) {
							$active = 'active';
						}
						$subMenu .= '
							<div class="menu-item '. $hasSub .' '. $active .'">
								<a href="'. $menu['url'] .'" class="menu-link">' . $hasTitle . $hasCaret .'</a>
								'. $subSubMenu .'
							</div>
						';
					}
					return $subMenu;
				}
				
				foreach (config('sidebar.menu') as $key => $menu) {
					$GLOBALS['parent_active'] = '';
					
					$hasSub = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
					$hasCaret = (!empty($menu['caret'])) ? '<div class="menu-caret"></div>' : '';
					$hasIcon = (!empty($menu['icon'])) ? '<div class="menu-icon"><i class="'. $menu['icon'] .'"></i></div>' : '';
					$hasImg = (!empty($menu['img'])) ? '<div class="menu-icon-img"><img src="'. $menu['img'] .'" /></div>' : '';
					$hasLabel = (!empty($menu['label'])) ? '<span class="menu-label">'. $menu['label'] .'</span>' : '';
					$hasTitle = (!empty($menu['title'])) ? '<div class="menu-text">'. $menu['title'] . $hasLabel .'</div>' : '';
					$hasBadge = (!empty($menu['badge'])) ? '<div class="menu-badge">'. $menu['badge'] .'</div>' : '';
					
					$subMenu = '';
					
					if (!empty($menu['sub_menu'])) {
						$GLOBALS['sub_level'] = 0;
						$subMenu .= '<div class="menu-submenu">';
						$subMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
						$subMenu .= '</div>';
					}
					
					
					$active = '';

				if (!empty($menu['route-names'])) {
					foreach ($menu['route-names'] as $routeName) {
						if (Route::currentRouteName() === $routeName) {
							$active = 'active';
							break;
						}
					}
				}

					if (!empty($menu['route-name']) && Route::currentRouteName() == $menu['route-name']) {
					    $active = 'active';
					} elseif (!empty($menu['route-prefix']) && Str::startsWith(Route::currentRouteName(), $menu['route-prefix'])) {
					    $active = 'active';
					} elseif (!empty($GLOBALS['parent_active'])) {
					    $active = 'active';
					}

					echo '
						<div class="menu-item '. $hasSub .' '. $active .'">
							<a href="'. $menu['url'] .'" class="menu-link">
								'. $hasImg .'
								'. $hasIcon .'
								'. $hasTitle .'
								'. $hasBadge .'
								'. $hasCaret .'
							</a>
							'. $subMenu .'
						</div>
					';
				}
			@endphp
			<!-- BEGIN minify-button -->
			<div class="menu-item d-flex">
				<a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
			</div>
			<!-- END minify-button -->
		
		</div>
		<!-- END menu -->
	</div>
	<!-- END scrollbar -->
</div>
<div class="app-sidebar-bg" {{ $appSidebarAttr }}></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
<!-- END #sidebar -->

   <!-- Change Password Modal -->
   <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form id="change-password-form">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="mb-3">
              <label for="current_password" class="form-label">Current Password</label>
              <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            
            <div class="mb-3">
              <label for="new_password" class="form-label">New Password</label>
              <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            
            <div class="mb-3">
              <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
            </div>
          
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 <!-- Help Modal -->
 <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="helpModalLabel"><i class="fa fa-info-circle me-2 text-primary"></i>Using the System</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Welcome to the Case Management System!</p>
          <ul>
              <li>🔒 <strong>Security Reminder:</strong> If you haven’t changed your password in the last 3 months, we recommend doing so to keep your account secure.</li>
              <li>🙅 <strong>Never share your password</strong> with anyone, including colleagues. Your login is personal and confidential.</li>
              <li>🚀 <strong>Good news!</strong> Our system is built to be user-friendly, intuitive, and efficient — helping you manage your work with ease.</li>
          </ul>
          <p>If you need further assistance, don’t hesitate to reach out to support.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Got it</button>
        </div>
      </div>
    </div>
  </div>
  
@push('scripts')
<script>
    $('#change-password-trigger').on('click', function () {
        $('#changePasswordModal').modal('show');
    });




    $('#change-password-form').on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        let data = form.serialize();

        $.ajax({
            url: "{{ route('lawyer.changePassword') }}",
            method: 'POST',
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    }).then(() => {
                        $('#changePasswordModal').modal('hide');
                        form[0].reset(); // clear the form
                    });
                }
            },
            error: function(xhr) {
                let res = xhr.responseJSON;
                let msg = res.message || 'Something went wrong';

                if (res.errors) {
                    // Show first validation error
                    msg = Object.values(res.errors)[0][0];
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            }
        });
    });

    
    $('#help-trigger').on('click', function () {
        $('#helpModal').modal('show');
    });


</script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Get all collapsible elements
		document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(link => {
			const targetSelector = link.getAttribute('data-bs-target');
			const target = document.querySelector(targetSelector);
			const icon = link.querySelector('.collapse-chevron');

			if (!target || !icon) return;

			target.addEventListener('shown.bs.collapse', () => {
				icon.classList.remove('fa-chevron-right');
				icon.classList.add('fa-chevron-down');
			});

			target.addEventListener('hidden.bs.collapse', () => {
				icon.classList.remove('fa-chevron-down');
				icon.classList.add('fa-chevron-right');
			});
		});
	});
</script>


@endpush
