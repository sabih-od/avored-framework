<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Edit Group
                </h2>

            </div>

            <div class="mt-5 w-full">
                <x-avored::form.form action="{{ route('admin.group-chat.update', $group) }}" method="PUT"
                                     enctype="multipart/form-data">

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                        name="title"
                                        autofocus
                                        value="{!! $group->title ?? '' !!}"
                                        label="Title"
                                ></x-avored::form.input>
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
                                <img src="{{ $group->media_upload['url'] ?? '' }}" alt=""/>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex">
                        <button type="submit"
                                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                            Update
                        </button>

                        <x-avored::link url="{{ route('admin.group-chat.index') }}" class="ml-3" style="button-default">
                            Cancel
                        </x-avored::link>
                    </div>
                </x-avored::form.form>
            </div>
        </div>

    </div>

</x-avored::layout>
