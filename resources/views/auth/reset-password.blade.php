<x-guest-layout>
    @section('title')
    Reset Password
    @endsection

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="position-relative overflow-hidden min-vh-100 w-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
                    <div class="card mb-0" style="background: rgba(255, 255, 255, 0.527); backdrop-filter: blur(10px); border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <div class="card-body">
                            <a href="{{ url('/') }}" class="text-nowrap logo-img d-flex align-items-center justify-content-center gap-2 mb-4 w-100">
                                <b class="logo-icon">
                                    <img src="{{ asset('assets') }}/images/logos/Logo Cita-kedua.jpg" alt="homepage" class="dark-logo img-fluid" style="max-width: 100%; height: auto;">
                                </b>
                            </a>
                            <div class="content-top-agile px-20 pt-20 pb-0 text-center">
                                <h2 class="mb-10 text-2xl font-semibold text-primary">Reset Password ?</h2>
                                <p class="mb-0 text-fade">Enter your email to reset your password.</p>
                            </div>
                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" name="email" id="email" class="form-control text-black" placeholder="Example@smii.co.id">
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4">Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
