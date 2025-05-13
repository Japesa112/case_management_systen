@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'KU CMS')
  <img src="{{ asset('images/ku_icon.png') }}" alt="{{ $slot }}" style="height: 60px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
