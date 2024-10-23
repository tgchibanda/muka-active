@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'MukaActive')
<img src="{{ asset('storage/images/logo-black.png') }}" class="logo" alt="MukaActiveLogo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
