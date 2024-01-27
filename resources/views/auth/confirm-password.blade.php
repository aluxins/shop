<x-app-layout>

    <x-slot name="title">
        {{ __('auth.confirm.title') }}
    </x-slot>

    <x-slot name="heading">
        {{ __('auth.confirm.heading') }}
    </x-slot>

    <x-slot name="header">
        @include('layouts.header', ['open' => false])
    </x-slot>

    <div class="w-full sm:max-w-md m-auto px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.confirm.information') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('auth.confirm.password')" />

                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end mt-4">
                <x-primary-button>
                    {{ __('auth.confirm.button') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
