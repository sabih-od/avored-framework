<x-avored::layout>
<div>
    <div class="p-5">
        <div class="flex w-full">
            <h2 class="text-2xl text-red-700 font-semibold">
                {{ __('Contact Page Setting') }}
            </h2>
        </div>

        <div class="w-full mt-5">
            <!-- component -->
            <div class="flex overflow-hidden">
                <div class="w-1/2">
                    <x-avored::form.form
                            action="{{ route('admin.settings.contact.update') }}"
                            method="POST"
                            class="bg-white shadow-md rounded my-6 p-5">
                        <x-avored::form.input
                                name="location"
                                value="{{ $setting->location ?? '' }}"
                                label="Location"
                        ></x-avored::form.input>
                        <x-avored::form.input
                                name="email"
                                value="{{ $setting->email ?? '' }}"
                                label="Email"
                        ></x-avored::form.input>
                        <x-avored::form.input
                                name="phone"
                                value="{{ $setting->phone ?? '' }}"
                                label="Phone"
                        ></x-avored::form.input>
                        <x-avored::form.input
                                name="map_link"
                                value="{{ $setting->map_link ?? '' }}"
                                label="Map Link"
                        ></x-avored::form.input>

                        <div class="mt-6 flex">
                            <button type="submit"
                                    class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">

                                {{ __('Update') }}
                            </button>
                        </div>
                    </x-avored::form.form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-avored::layout>
