<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Vai trò (mặc định: Doanh nghiệp) -->
<input type="hidden" name="role" value="doanh_nghiep">

<!-- Xã/Phường -->
<div class="mt-4">
    <x-input-label for="xa_phuong_id" :value="__('Xã/Phường')" />
    <select id="xa_phuong_id" name="xa_phuong_id" class="block mt-1 w-full appearance-none bg-white border border-gray-300 rounded-lg shadow-sm px-3 py-2 pr-8 text-sm focus:border-indigo-500 focus:ring-indigo-500 bg-[url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 viewBox=%270 0 20 20%27 fill=%27%236b7280%27%3E%3Cpath fill-rule=%27evenodd%27 d=%27M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z%27 clip-rule=%27evenodd%27/%3E%3C/svg%3E')] bg-no-repeat bg-[right_0.5rem_center] bg-[length:1.25em]">
        <option value="">-- Chọn xã/phường --</option>
        @foreach (\App\Models\XaPhuong::all() as $xa)
            <option value="{{ $xa->id }}">{{ $xa->ten_xa }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('xa_phuong_id')" class="mt-2" />
</div>

<!-- Tên doanh nghiệp -->
<div class="mt-4">
    <x-input-label for="ten_doanh_nghiep" :value="__('Tên doanh nghiệp')" />
    <x-text-input id="ten_doanh_nghiep" class="block mt-1 w-full" type="text" name="ten_doanh_nghiep" :value="old('ten_doanh_nghiep')" />
    <x-input-error :messages="$errors->get('ten_doanh_nghiep')" class="mt-2" />
</div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
