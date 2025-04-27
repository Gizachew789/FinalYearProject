@component('mail::message')
# Welcome to Our System!

You have been registered successfully.

Here is your temporary password:

@component('mail::panel')
{{ $password }}
@endcomponent

Please log in and change your password as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
