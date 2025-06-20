@component('mail::message')
# Upcoming Events & Hearings

Here is a summary of upcoming legal activities and deadlines:

@forelse ($items as $item)
---

### {{ $item['type'] ?? 'Event' }}
- **Description:** {{ ucfirst($item['description'] ?? 'N/A') }}
- **Scheduled At:** {{ \Carbon\Carbon::parse($item['datetime'])->format('F d, Y h:i A') }}
- **Case Name:** {{ $item['case_name'] ?? 'N/A' }}

@component('mail::button', ['url' => route('cases.show', $item['case_id'])])
View Case #{{ $item['case_id'] ?? 'N/A' }}
@endcomponent

@empty
No upcoming items at this time.
@endforelse

@component('mail::button', ['url' => url('/dashboard')])
Go to Dashboard
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
