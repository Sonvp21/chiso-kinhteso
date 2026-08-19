<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Cảm ơn bạn đã đăng ký! Vui lòng xác thực email bằng cách bấm vào liên kết chúng tôi vừa gửi. Nếu chưa nhận được email, chúng tôi sẽ gửi lại.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Một liên kết xác thực mới đã được gửi tới email bạn đã đăng ký.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Gửi lại email xác thực') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Đăng xuất') }}
            </button>
        </form>
    </div>
</x-guest-layout>
