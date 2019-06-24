@component('mail::message')
# NEW OFFICE
The office with name
{{ $newOffice->name }}
was created.
@component('mail::button', ['url' => '/admin/office'])
Show office
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
