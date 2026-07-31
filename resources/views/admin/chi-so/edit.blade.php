<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Sửa chỉ số</h2></x-slot>
    <div class="py-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.chi-so.update', $chiSo) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
            @csrf @method('PUT')
            @include('admin.chi-so._form')
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Cập nhật</button>
        </form>
    </div>
</x-app-layout>