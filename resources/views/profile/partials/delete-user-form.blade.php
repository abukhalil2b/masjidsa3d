<section class="space-y-6">
    <x-primary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'create-new-student')"
    >{{ __('New Student') }}</x-primary-button>

    <x-modal name="create-new-student" :show="$errors->userDeletion->isNotEmpty()" focusable>
       
            <div class="mt-6">
                <x-input-label for="name" value="{{ __('name') }}" class="sr-only" />

                <x-text-input
                    id="name"
                    name="name"
                    type="name"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('name') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
    </x-modal>


</section>
