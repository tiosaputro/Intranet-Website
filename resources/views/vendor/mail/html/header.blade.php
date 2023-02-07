<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ asset('app-assets/images/logo/logo.png') }}" width="140" alt="EMP - SIAP">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
