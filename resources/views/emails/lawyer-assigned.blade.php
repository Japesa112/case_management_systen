@component('mail::message')
# New Case Assignment

Dear {{ $lawyer->full_name }},

You have been assigned to the case **{{ $case->case_name }}**.

**Case Number:** {{ $case->case_number }}  
**Assigned Date:** {{ now()->format('F d, Y') }}

@if($attachment)
**Attached Document:** {{ $attachment->file_path }}
@endif

@component('mail::button', ['url' => route('cases.show', $case->case_id)])
View Case
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
