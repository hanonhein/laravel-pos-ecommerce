{{-- resources/views/auth/magic-link-verify.blade.php --}}

<x-guest-layout>
    <div class="card bg-body-tertiary shadow-lg border-secondary">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <a href="/" class="h2 text-white text-decoration-none">
                    E-Shop
                </a>
                <p class="text-white-50">A login code has been sent to your email. Please enter it below.</p>
            </div>

            <form method="POST" action="{{ route('magic-link.verify') }}">
                @csrf

                {{-- We pass the email along in a hidden field --}}
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Verification Code -->
                <div class="mb-3">
                    <label for="token" class="form-label">{{ __('6-Digit Code') }}</label>
                    <input id="token" class="form-control @error('token') is-invalid @enderror" type="text" name="token" required autofocus />
                    @error('token')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Verify & Log In
                    </button>
                </div>
            </form>

            <div class="text-center mt-4">
                <p class="text-white-50">Didn't get a code?
                    <a href="{{ route('magic-link.request', ['email' => $email]) }}" class="text-white text-decoration-none fw-bold">Request a new one</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
