
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">          
            {{ __("Store's Information") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update or Create your store address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.createOrUpdateStore') }}" class="mt-6 space-y-6">
        @csrf
        
        <div>
            <x-input-label for="street" :value="__('Street Name')" />
            <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" :value="old('street', $store_address != null ? $store_address->street : '')" required autofocus autocomplete="street" />
            <x-input-error class="mt-2" :messages="$errors->get('street')" />
        </div>
        <div class="row">
            <div class="col">
                <x-input-label for="barangay" :value="__('Barangay')" />
                <x-text-input id="barangay" name="barangay" type="text" class="mt-1 block w-full" :value="old('barangay',$store_address != null ? $store_address->barangay : '')" required autofocus autocomplete="barangay" />
                <x-input-error class="mt-2" :messages="$errors->get('barangay')" />
            </div>
            <div class="col">
                <x-input-label for="city" :value="__('Municipality/City')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $store_address != null ? $store_address->city : '')" required autofocus autocomplete="city" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
            <div class="col">
                <x-input-label for="province" :value="__('Province')" />
                <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="old('province', $store_address != null ? $store_address->province : '')" required autofocus autocomplete="province" />
                <x-input-error class="mt-2" :messages="$errors->get('province')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            
            @if (session('status_store') === 'profile-updated')
            <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>