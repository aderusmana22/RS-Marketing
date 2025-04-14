<section>
    <header>
        <h2 class="h4">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.updates') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- <div>
            <label for="nik" class="form-label">{{ __('Nik') }}</label>
            <input id="nik" name="nik" type="text" class="form-control" :value="old('nik', $user->nik)" required autofocus autocomplete="nik">
            @error('nik')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div> --}}

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            {{-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-muted">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-2">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif --}}
        </div>
        <div class="mb-3">
            <label for="avatar" class="form-label" style="display: block;">{{ __('Avatar') }}</label>
            @if ($user->avatar)
                <img id="avatar-preview" src="{{ asset('storage/uploads/user_avatars/' . $user->avatar) }}" alt="Avatar" class="mb-4" style="width: 100px; height: 100px;">
            @else
                <img id="avatar-preview" src="{{ asset('assets/images/logos/sinarmeadow.png') }}" alt="Avatar" class="mb-4" style="width: 100px; height: 100px;">
            @endif
            <input type="file" name="avatar" id="avatar" class="form-control mt-1" onchange="previewAvatar()">
            @error('avatar')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <script>
            function previewAvatar() {
                var fileInput = document.getElementById('avatar');
                var file = fileInput.files[0];
                var reader = new FileReader();

                reader.onloadend = function () {
                    var img = document.getElementById('avatar-preview');
                    img.src = reader.result;
                    img.classList.remove('hidden');
                }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    var img = document.getElementById('avatar-preview');
                    img.src = "";
                    img.classList.add('hidden');
                }
            }
        </script>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
