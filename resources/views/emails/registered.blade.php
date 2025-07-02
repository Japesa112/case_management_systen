{{-- resources/views/emails/user/registered.blade.php --}}
@component('mail::message')
# Welcome to KU Legal Case Management System

Dear {{ $user->full_name }},

You have been successfully registered in the **KU Legal Case Management System** (legal.ku.ac.ke).

You can now log in using your **Google account** to access and manage your information.

@component('mail::button', ['url' => url('/')])
Log In
@endcomponent

If you believe this was a mistake, please contact the administrator.

Thanks,  
{{ config('app.name') }}
@endcomponent
