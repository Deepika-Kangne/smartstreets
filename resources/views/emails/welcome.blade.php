@component('mail::message')
# Welcome..!!!

Thanks to get Register with us.
@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent