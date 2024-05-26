@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Muka-Active')
<img src="{{ asset('storage/images/logo-black.png') }}" class="logo" alt="Muka-Active Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
