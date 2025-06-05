<x-mail::message>
# Verify your email

Your 6-digit verification code is:

<x-mail::panel>
## {{ $code }}
</x-mail::panel>

Code expires in 15 minutes.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>