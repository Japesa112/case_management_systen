@php
    $appHeaderAttr = !empty($appHeaderInverse) ? ' data-bs-theme=dark' : '';
    $appHeaderMenu = $appHeaderMenu ?? '';
    $appHeaderMegaMenu = $appHeaderMegaMenu ?? '';
    $appHeaderTopMenu = $appHeaderTopMenu ?? '';
 
 

    $full_name = Auth::user()->full_name;

@endphp





<!-- BEGIN #header -->
<header id="header" class="app-header py-2 px-3 shadow-sm" {{ $appHeaderAttr }} style="background-color: #f8f5f5;">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            
            <!-- Navbar Brand and Mobile Togglers -->
            <div class="d-flex align-items-center gap-3">
                @if ($appSidebarTwo)
                    <button class="btn btn-sm d-md-none" type="button" data-toggle="app-sidebar-end-mobile">
                        <i class="fa fa-bars"></i>
                    </button>
                @endif

                <a href="/" class="navbar-brand d-flex align-items-center gap-2 fw-bold fs-5 text-dark">
                    <img src="{{ asset('images/icon_ku.png') }}" alt="University Logo" height="36" />
                    <span><strong>Kenyatta University</strong></span>
                </a>

                @if ($appHeaderMegaMenu && !$appSidebarTwo)
                    <button class="btn btn-sm d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#top-navbar">
                        <i class="fa fa-cog"></i>
                    </button>
                @endif

                @if (($appTopMenu && !$appSidebarHide) || ($appTopMenu && $appSidebarHide && !$appSidebarTwo))
                    <button class="btn btn-sm d-md-none" type="button" data-toggle="app-top-menu-mobile">
                        <i class="fa fa-cog"></i>
                    </button>
                @endif

                @if (!$appSidebarHide)
                    <button class="btn btn-sm d-md-none" type="button" data-toggle="app-sidebar-mobile">
                        <i class="fa fa-bars"></i>
                    </button>
                @endif
            </div>

            <!-- Center Title -->
            <!-- Add class to trigger animation -->
            <div class="text-center flex-grow-1 title-animate">
                <h1 class="m-0 fs-4 text-primary">Case Management System</h1>
            </div>


            <!-- Right-side Navbar Items -->
            <div class="d-flex align-items-center gap-3">
                <!-- Notifications -->
                <div class="dropdown">
                   <a href="#" id="notificationDropdownToggle" data-bs-toggle="dropdown" class="btn btn-info position-relative">

                        <i class="fa fa-bell"></i>
                        <span id="notification-count-total" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">7</span>
                    </a>
                    @include('includes.component.header-dropdown-notification')

                </div>

                <!-- Language Bar -->
                @isset($appHeaderLanguageBar)
                    @include('includes.component.header-language-bar')
                @endisset

                <!-- User Dropdown -->
                <div class="navbar-item navbar-user dropdown">
                    <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                       
                        <span>
                            <span class="d-none d-md-inline">{{ $full_name }}</span>
                            <b class="caret"></b>
                        </span>
                    </a>
                    @include('includes.component.header-dropdown-profile')
                </div>

                <!-- App Sidebar End -->
                @if ($appSidebarTwo)
                    <a href="javascript:;" data-toggle="app-sidebar-end" class="btn btn-light d-none d-md-inline-block">
                        <i class="fa fa-th"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>
<!-- END #header -->


@push('scripts')
<script>
$(document).ready(function () {





   
    $('#notificationDropdownToggle').on('click', function () {
       

        $.get('{{ route('notifications.fetch') }}', function (data) {
            let html = '';
            let count = data.length;
            

            data.forEach(item => {
               
                let iconHtml = item.icon 
                    ? `<i class="${item.icon} media-object bg-gray-500"></i>` 
                    : `<i class="fa fa-info-circle media-object bg-gray-500"></i>`;

                html += `
                                  <div class="dropdown-item px-3 py-2 ${item.pivot?.is_read ? '' : 'bg-light'} border-bottom" data-id="${item.notification_id}" id="notification-${item.notification_id}">
                  <div class="d-flex align-items-start">
                    <div class="me-3 flex-shrink-0">
                      <i class="${item.icon || 'fa fa-info-circle'} media-object bg-gray-500 text-white p-2 rounded-circle"></i>
                    </div>

                    <div class="flex-grow-1">
                      <h6 class="mb-1 fw-bold">${item.title}</h6>
                      <p class="mb-1 text-wrap text-break">${item.message ?? ''}</p>
                      <small class="text-muted">${timeAgo(item.created_at)}</small>
                    </div>

                    ${!item.pivot?.is_read ? `
                      <div class="ms-3 mt-1">
                        <button class="btn btn-sm btn-outline-success mark-as-read" data-id="${item.notification_id}" title="Mark as Read">
                          <i class="fa fa-check"></i>
                        </button>
                      </div>
                    ` : ''}
                  </div>
                </div>

                `;


            });

            if (count > 4) {
              $('.dropdown-footer').show();
            } else {
              $('.dropdown-footer').hide();
            }

            $('#notification-list').html(html);
            $('#notification-count').text(count);
        });
    });

    function timeAgo(dateString) {
        let date = new Date(dateString);
        let now = new Date();
        let seconds = Math.floor((now - date) / 1000);

        let interval = Math.floor(seconds / 31536000);
        if (interval >= 1) return interval + " year" + (interval > 1 ? "s" : "") + " ago";

        interval = Math.floor(seconds / 2592000);
        if (interval >= 1) return interval + " month" + (interval > 1 ? "s" : "") + " ago";

        interval = Math.floor(seconds / 86400);
        if (interval >= 1) return interval + " day" + (interval > 1 ? "s" : "") + " ago";

        interval = Math.floor(seconds / 3600);
        if (interval >= 1) return interval + " hour" + (interval > 1 ? "s" : "") + " ago";

        interval = Math.floor(seconds / 60);
        if (interval >= 1) return interval + " minute" + (interval > 1 ? "s" : "") + " ago";

        return "Just now";
    }


   $(document).on('click', '.mark-as-read', function (e) {
    e.stopPropagation();
    const notificationId = $(this).data('id');

    let url = "{{ route('notifications.markAsRead', ':id') }}".replace(':id', notificationId);

    $.post(url, {
        _token: '{{ csrf_token() }}'
    }, function (response) {
        if (response.success) {
            // Fade out and remove the notification
            $(`#notification-${notificationId}`).fadeOut(300, function () {
                $(this).remove();
                updateNotificationCount(); // Update count after removal
            });
        }
    });
});


function updateNotificationCount() {
    $.get("{{ route('notifications.unreadCount') }}", function (response) {
        $('#notification-count').text(response.count);
        $('#notification-count-total').text(response.count);
    });
}




});



</script>

<script>
function updateNotificationCounters() {
    $.get("{{ route('notifications.unreadCount') }}", function (data) {
        if (data.count !== undefined) {
            $('#notification-count').text(data.count);
            $('#notification-count-total').text(data.count);
            
            // Hide badge if no unread notifications
            if (data.count === 0) {
                $('#notification-count-total').addClass('d-none');
            } else {
                $('#notification-count-total').removeClass('d-none');
            }
        }
    });
}

// Call once on page load
updateNotificationCounters();

// Optionally poll every 60 seconds
setInterval(updateNotificationCounters, 60000);
</script>

@endpush
