@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<link rel="icon" href="{{ asset('img/logo-kemhan.png') }}" type="image/png">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>