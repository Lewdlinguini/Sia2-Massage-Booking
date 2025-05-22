@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; max-height: 90vh; overflow-y: auto;">
        <h3 class="text-center mb-4" style="color: rgba(212, 163, 115, 0.9);">Edit Profile</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
            @csrf
            @method('PUT')

            <div class="text-center mb-3 position-relative" style="width: 100px; margin-left: auto; margin-right: auto;">
                @if(auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                         class="rounded-circle img-fluid" 
                         alt="Profile Picture" 
                         id="profile-picture-display" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <img src="{{ asset('default-avatar.png') }}" 
                         class="rounded-circle img-fluid" 
                         alt="Default Avatar" 
                         id="profile-picture-display" 
                         style="width: 100px; height: 100px; object-fit: cover;">
                @endif

                <!-- Gallery icon overlay, clickable -->
                <div id="file-picker-icon" style="
                    position: absolute;
                    bottom: 0;
                    right: 0;
                    background: rgba(0,0,0,0.6);
                    border-radius: 50%;
                    width: 28px;
                    height: 28px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 16px;
                    cursor: pointer;
                    ">
                    <!-- Gallery icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="16" height="16" fill="currentColor" 
                         class="bi bi-image" viewBox="0 0 16 16">
                        <path d="M14.002 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zm-1 1H3v7.293l3.146-3.147a.5.5 0 0 1 .708 0L10 12.293l3-3V4z"/>
                        <path d="M10.648 8.646a1.5 1.5 0 1 0-2.195 2.195l2.195-2.195z"/>
                    </svg>
                </div>

                <!-- Hidden file input -->
                <input type="file" class="d-none" id="profile_picture" name="profile_picture" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="first_name" class="form-label" style="color: #4a3b2b;">First Name</label>
                <input
                    type="text"
                    class="form-control @error('first_name') is-invalid @enderror"
                    id="first_name"
                    name="first_name"
                    value="{{ old('first_name', auth()->user()->first_name) }}"
                    required
                >
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label" style="color: #4a3b2b;">Last Name</label>
                <input
                    type="text"
                    class="form-control @error('last_name') is-invalid @enderror"
                    id="last_name"
                    name="last_name"
                    value="{{ old('last_name', auth()->user()->last_name) }}"
                    required
                >
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="age" class="form-label" style="color: #4a3b2b;">Age</label>
                <input
                    type="number"
                    class="form-control @error('age') is-invalid @enderror"
                    id="age"
                    name="age"
                    value="{{ old('age', auth()->user()->age) }}"
                    min="1"
                    required
                >
                @error('age')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="country_code" class="form-label" style="color: #4a3b2b;">Cellphone Number</label>
                <div class="input-group">
                    @php
                        $codes = [
                            '+1' => 'USA/Canada (+1)',
                            '+44' => 'UK (+44)',
                            '+61' => 'Australia (+61)',
                            '+63' => 'Philippines (+63)',
                            '+91' => 'India (+91)',
                            '+81' => 'Japan (+81)',
                            '+49' => 'Germany (+49)',
                        ];
                        $userCountryCode = old('country_code') ?? (auth()->user()->country_code ?? '+63');
                        $rawCellphone = old('cellphone') ?? auth()->user()->cellphone;

                        if (str_starts_with($rawCellphone, $userCountryCode)) {
                            $rawCellphone = substr($rawCellphone, strlen($userCountryCode));
                        }

                        function formatCellphone($number, $countryCode) {
                            $digits = preg_replace('/\D/', '', $number);
                            if ($countryCode === '+63') {
                                if (strlen($digits) > 3) {
                                    $part1 = substr($digits, 0, 3);
                                    $part2 = substr($digits, 3, 3);
                                    $part3 = substr($digits, 6, 4);
                                    return trim("$part1 $part2 $part3");
                                }
                            }
                            return $digits;
                        }

                        $formattedCellphone = formatCellphone($rawCellphone, $userCountryCode);
                    @endphp
                    <select
                        id="country_code"
                        name="country_code"
                        class="form-select @error('country_code') is-invalid @enderror"
                        style="max-width: 100px;"
                        required
                    >
                        @foreach($codes as $code => $country)
                            <option value="{{ $code }}" {{ $code === $userCountryCode ? 'selected' : '' }}>{{ $country }}</option>
                        @endforeach
                    </select>

                    <input
                        type="tel"
                        inputmode="tel"
                        pattern="[0-9\s]{6,15}"
                        maxlength="15"
                        class="form-control @error('cellphone') is-invalid @enderror"
                        id="cellphone"
                        name="cellphone"
                        placeholder="912 345 6789"
                        value="{{ $formattedCellphone }}"
                        required
                    >
                </div>
                @error('country_code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('cellphone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label" style="color: #4a3b2b;">House Address</label>
                <input
                    type="text"
                    class="form-control @error('address') is-invalid @enderror"
                    id="address"
                    name="address"
                    value="{{ old('address', auth()->user()->address) }}"
                >
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label" style="color: #4a3b2b;">Email</label>
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    value="{{ auth()->user()->email }}"
                    readonly
                >
            </div>

            <button type="submit" class="btn" style="background: rgba(212, 163, 115, 0.9); color: white; width: 100%;">Save Changes</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filePickerIcon = document.getElementById('file-picker-icon');
    const profilePictureInput = document.getElementById('profile_picture');
    const profilePictureDisplay = document.getElementById('profile-picture-display');

    // Clicking the gallery icon triggers the hidden file input
    filePickerIcon.addEventListener('click', () => {
        profilePictureInput.click();
    });

    // Preview the new selected image before upload
    profilePictureInput.addEventListener('change', event => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                profilePictureDisplay.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Cellphone formatting code (unchanged)
    const cellphoneInput = document.getElementById('cellphone');
    const countryCodeSelect = document.getElementById('country_code');

    cellphoneInput.addEventListener('input', () => {
        if (countryCodeSelect.value === '+63') {
            const oldValue = cellphoneInput.value;
            const oldCursor = cellphoneInput.selectionStart;
            let digits = oldValue.replace(/\D/g, '');

            let formatted = digits;
            if (digits.length > 3 && digits.length <= 6) {
                formatted = digits.replace(/(\d{3})(\d+)/, '$1 $2');
            } else if (digits.length > 6) {
                formatted = digits.replace(/(\d{3})(\d{3})(\d+)/, '$1 $2 $3');
            }

            let newCursor = oldCursor;
            const digitsBeforeCursor = oldValue.slice(0, oldCursor).replace(/\D/g, '').length;
            let count = 0;
            for (let i = 0; i < formatted.length; i++) {
                if (/\d/.test(formatted[i])) {
                    count++;
                }
                if (count >= digitsBeforeCursor) {
                    newCursor = i + 1;
                    break;
                }
            }

            cellphoneInput.value = formatted;
            cellphoneInput.setSelectionRange(newCursor, newCursor);
        }
    });
});
</script>
@endsection
