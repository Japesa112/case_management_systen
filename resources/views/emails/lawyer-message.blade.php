@component('mail::message')
# Message Regarding Case

**Case Title:** {{ $case->case_name }}

@if($case->first_hearing_date)
**First Hearing Date:** {{ $case->first_hearing_date }}
@endif

---

@if(!empty($customMessage))
**Message from Admin:**

{{ $customMessage }}

Thanks,<br>
{{ config('app.name') }}
@endif

@endcomponent


