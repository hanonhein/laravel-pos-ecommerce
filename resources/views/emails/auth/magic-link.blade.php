<x-mail::message>
# Your Magic Login Link

Hi {{ $user->name }},

You requested a passwordless login link for your account on E-Shop.

Click the button below to log in instantly. This link is valid for 15 minutes and can only be used once.

<x-mail::button :url="route('magic-link.login', ['token' => $token])">
Log In to E-Shop
</x-mail::button>

If you did not request this email, you can safely ignore it.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
