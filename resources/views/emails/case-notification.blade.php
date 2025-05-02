@component('mail::message')
@if($isReminder)
# Hearing Date Reminder

The hearing for case **{{ $case->case_name }}** is approaching:
@if($case->hearing_date)
**Hearing Date:** {{ $case->first_hearing_date }}
@else
**Hearing Date:** Not specified
@endif

@else
# New Case Created

A new case has been registered:
**Case Title:** {{ $case->case_name }}

@if($case->first_hearing_date)
**Hearing Date:** {{ $case->first_hearing_date }}
@else
**Hearing Date:** Not specified
@endif

@endif

@if(!empty($customMessage))
---

**Message from Admin:**

{{ $customMessage }}

@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
