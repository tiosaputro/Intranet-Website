@component('mail::message')
<div style="text-align: center;">
<strong>Hi, <span style="color:#e7a026;">{{ $data['name'] }}</span> !</strong>
<br/>
{{ $data['headerNotif']}}
</div>
<br/>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" border="0">
    <tr>
        <td>
            <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="body" width="100%" cellpadding="0" cellspacing="0">
                        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                            role="presentation">
                            <!-- Body content -->
                            <tr>
                                <td class="content-cell">
                                    <div class="title">
                                        {{ $data['bodyNotif'] }}
                                    </div>
                                    <div class="body-text">
                                        {!! $data['contentNotif'] !!}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

Thanks,<br>
Admin EMP
@endcomponent
