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

        <!-- Vai trò -->
<div class="mt-4">
    <x-input-label for="role" :value="__('Vai trò')" />
    <select id="role" name="role" required class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="doanh_nghiep">Doanh nghiệp</option>
        <option value="quan_tri">Quản trị</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>

<!-- Xã/Phường -->
<div class="mt-4">
    <x-input-label for="xa_phuong_id" :value="__('Xã/Phường')" />
    <select id="xa_phuong_id" name="xa_phuong_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
