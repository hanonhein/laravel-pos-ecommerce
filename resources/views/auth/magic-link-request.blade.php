{{-- resources/views/auth/magic-link-request.blade.php --}}

<x-guest-layout>
    <div class="card bg-body-tertiary shadow-lg border-secondary">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <a href="/" class="h2 text-white text-decoration-none">
                    E-Shop
                </a>
                <p class="text-white-50">Enter your email to receive a magic login link.</p>
            </div>

            {{-- Session Status for success messages --}}
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('magic-link.request') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Send Magic Link
                    </button>
                </div>
            </form>

            {{-- Link back to the regular Login Page --}}
            <div class="text-center mt-4">
                <p class="text-white-50">Remember your password?
                    <a href="{{ route('login') }}" class="text-white text-decoration-none fw-bold">Log in here</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
{{-- resources/views/auth/magic-link-request.blade.php --}}

<x-guest-layout>
    <div class="card bg-body-tertiary shadow-lg border-secondary">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <a href="/" class="h2 text-white text-decoration-none">
                    E-Shop
                </a>
                <p class="text-white-50">Enter your email to receive a magic login link.</p>
            </div>

            {{-- Session Status for success messages --}}
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('magic-link.request') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Send Magic Link
                    </button>
                </div>
            </form>

            {{-- Link back to the regular Login Page --}}
            <div class="text-center mt-4">
                <p class="text-white-50">Remember your password?
                    <a href="{{ route('login') }}" class="text-white text-decoration-none fw-bold">Log in here</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
