<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Create Recipe
                </h2>

            </div>

            <div class="mt-5 w-full">
                <x-avored::form.form action="{{ route('admin.recipe.store') }}" method="POST" enctype="multipart/form-data">

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="name"
                                    autofocus
                                    value=""
                                    label="Name"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.easymde
                                    name="ingredients"
                                    value="{{ $recipe->ingredients ?? '' }}"
                                    label="Ingredients"
                                ></x-avored::form.easymde>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.easymde
                                    name="description"
                                    value="{{ $recipe->description ?? '' }}"
                                    label="Directions"
                                ></x-avored::form.easymde>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="image"
                                    type="file"
                                    label="Image"
                                ></x-avored::form.input>
                                <img src="{{ $recipe->media_upload['url'] ?? '' }}" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.toggle
                                    name="is_approved"
                                    value="{{ $recipe->is_approved ?? '0' }}"
                                    label="Is Approved"
                                ></x-avored::form.toggle>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex">
                        <button type="submit" class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                            Create
                        </button>

                        <x-avored::link url="" class="ml-3" style="button-default">
                            Cancel
                        </x-avored::link>
                    </div>
                </x-avored::form.form>
            </div>
        </div>

    </div>

</x-avored::layout>
