<x-guest-layout>
    @section('title')
        Login
    @endsection
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="position-relative overflow-hidden  min-vh-100 w-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
                    <div class="card mb-0"
                        style="background: rgba(255, 255, 255, 0.527); backdrop-filter: blur(10px); border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <div class="card-body">
                            <a href="{{ url('/') }}"
                                class="text-nowrap logo-img d-flex align-items-center justify-content-center gap-2 mb-4 w-100">
                                <b class="logo-icon">
                                    {{-- <img src="{{ asset('frontend/assets') }}/images/logo/logo.png" alt="homepage" class="dark-logo" style="width: 200px"> --}}
                                    <img src="{{ asset('frontend/assets/images/logo/logowhites.png') }}" alt="homepage"
                                        class="dark-logo img-fluid" style="max-width: 100%; height: auto;">
                                </b>
                            </a>
                            <h4 class="text-center text-bold">Login Page</h4>
                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" name="nik" id="nik" class="form-control text-black"
                                        placeholder="Masukan NIK" autocomplete="username" maxlength="6">
                                    <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="*********" autocomplete="current-password" required>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary" type="checkbox" value="single"
                                            id="remember_me">
                                        <label class="form-check-label text-dark" for="remember_me">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a class="text-primary fw-medium" href="{{ route('password.request') }}">Forgot
                                        Password?</a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4">Sign In</button>
                                <div class="d-flex align-items-center justify-content-center"></div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleEye');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
