<x-avored::layout>
    <div id="vapp">
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Edit Category
                </h2>

            </div>

            <div class="mt-5 w-full">
                <x-avored::form.form action="{{ route('admin.new_category.update', $_category) }}" method="PUT"
                                     enctype="multipart/form-data">

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                        name="name"
                                        autofocus
                                        value="{{ $_category->name ?? '' }}"
                                        label="Name"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex">
                        <button type="submit"
                                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                            Update
                        </button>

                        <x-avored::link url="" class="ml-3" style="button-default">
                            Cancel
                        </x-avored::link>
                    </div>
                </x-avored::form.form>
            </div>
        </div>
    </div>
    @push("scripts")
        <script src="{{ asset('vendor/avored/js/v-app.js')  }}"></script>
    @endpush
</x-avored::layout>



