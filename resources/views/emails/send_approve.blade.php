@component('mail::message')
# {{ $details['title'] }}

{{ $details['body'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

