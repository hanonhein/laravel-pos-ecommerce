<x-mail::message>
# Your Login Code

Hi {{ $user->name }},

Here is your one-time login code for E-Shop.

<x-mail::panel>
{{ $code }}
</x-mail::panel>

This code is valid for 15 minutes. Please enter it on the verification page to log in.

If you did not request this email, you can safely ignore it.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
