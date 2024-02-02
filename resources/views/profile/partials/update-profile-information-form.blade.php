<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('profile.updateProfile.title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('profile.updateProfile.information') }}
        </p>
    </header>

    <form id="send-profile" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
{{--
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
--}}
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

            <div class="sm:col-span-2">
                <x-input-label for="firstName" :value="__('profile.updateProfile.firstName')" />
                <x-text-input id="firstName" name="firstName" type="text" class="mt-1 block w-full" :value="old('firstName', $information['first_name'] ?? '')" required autofocus autocomplete="firstName" />
                <x-input-error class="mt-2" :messages="$errors->get('firstName')" />
            </div>

            <div class="sm:col-span-2">
                <x-input-label for="lastName" :value="__('profile.updateProfile.lastName')" />
                <x-text-input id="lastName" name="lastName" type="text" class="mt-1 block w-full" :value="old('lastName', $information['last_name'] ?? '')" required autofocus autocomplete="lastName" />
                <x-input-error class="mt-2" :messages="$errors->get('lastName')" />
            </div>

            <div class="sm:col-span-2">
                <x-input-label for="patronymic" :value="__('profile.updateProfile.patronymic')" />
                <x-text-input id="patronymic" name="patronymic" type="text" class="mt-1 block w-full" :value="old('patronymic', $information['patronymic'] ?? '')" autofocus autocomplete="patronymic" />
                <x-input-error class="mt-2" :messages="$errors->get('patronymic')" />
            </div>

            <div class="sm:col-span-2 sm:col-start-1">
                <x-input-label for="city" :value="__('profile.updateProfile.city')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $information['city'] ?? '')" autofocus autocomplete="city" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>

            <div class="sm:col-span-4">
                <x-input-label for="street-address" :value="__('profile.updateProfile.street')" />
                <x-text-input id="street-address" name="street-address" type="text" class="mt-1 block w-full" :value="old('street-address', $information['street_address'] ?? '')" autofocus autocomplete="street-address" />
                <x-input-error class="mt-2" :messages="$errors->get('street-address')" />
            </div>

            <div class="sm:col-span-2 sm:col-start-1">
                <x-input-label for="telephone" :value="__('profile.updateProfile.telephone')" />
                <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full" :value="old('telephone', $information['telephone'] ?? '')" autofocus autocomplete="telephone" />
                <x-input-error class="mt-2" :messages="$errors->get('telephone')" />
            </div>

            <div class="sm:col-span-4">
                <label for="about" class="block font-medium text-sm text-gray-700">{{ __('profile.updateProfile.about') }}</label>
                <textarea id="about" name="about" rows="2" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                    >{{ old('about', $information['about'] ?? '') }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('about')" />
            </div>

            <div class="col-span-full">

            </div>


        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.buttonSave') }}</x-primary-button>

            @if (session('status') === 'information-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('profile.messageSaved') }}</p>
            @endif
        </div>
    </form>
</section>
