{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Profile</h1>

    <div class="row">
        <div class="col-lg-8">
            {{-- 1. Update Profile Information Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Update your account's profile information and email address.</p>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                             @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                        @if (session('status') === 'profile-updated')
                            <span class="ms-3 text-success">Saved.</span>
                        @endif
                    </form>
                </div>
            </div>

            {{-- 2. Update Password Card --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Update Password</h5>
                </div>
                <div class="card-body">
                     <p class="text-muted">Ensure your account is using a long, random password to stay secure.</p>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                            <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('New Password') }}</label>
                            <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                             @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                         @if (session('status') === 'password-updated')
                            <span class="ms-3 text-success">Saved.</span>
                        @endif
                    </form>
                </div>
            </div>

            {{-- 3. Delete Account Card --}}
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Delete Account</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>

                    {{-- We can add a modal pop-up for this later to make it safer --}}
                    <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
