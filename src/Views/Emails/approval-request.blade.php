{{__('Hi!')}} {{ $approver->name }}

<br><br>

you are receiving this email because {{ $approval->requester->name }} has requested an approval from {{ $approval->currentLevel->name  }}.

<br><br>

{{ $approval->approvalProcess->name }} <br>

{{ $approval->approvalProcess->description }} <br><br>

<a href="{{ env('APP_URL') . '/approve/' . $approver->approval_level_request->token }}">Approve</a> / <a href="{{ env('APP_URL') . '/decline/' . $approver->approval_level_request->token }}">Deny</a>

