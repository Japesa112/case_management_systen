@component('mail::message')
# New Case Assignment

Dear {{ $lawyer->full_name }},

You have been assigned to the case **{{ $case->case_name }}**.

**Case Number:** {{ $case->case_number }}  

**Assigned Date:** {{ now()->format('F d, Y') }}

@component('mail::button', ['url' => route('cases.show', $case->case_id)])
View Case
@endcomponent

Please review the case details as soon as possible.

Thanks,  
{{ config('app.name') }}
@endcomponent
