{{__('Hi!')}} {{ $approver->name }}

<br><br>

you are receiving this email because {{ $approval->requester->name }} has requested an approval from you.

<br><br>

{{ $approval->name }} <br>

{{ $approver->description }} <br><br>

<a href="{{ env('APP_URL') . '/approve/' . $approval->token }}">Approve</a> / <a href="{{ env('APP_URL') . '/deny/' . $approval->token }}">Deny</a>

