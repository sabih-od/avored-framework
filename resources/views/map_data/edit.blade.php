<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Edit Group
                </h2>

            </div>

            <div class="mt-5 w-full">
                <x-avored::form.form action="{{ route('admin.map-data.update', $item) }}" method="PUT"
                                     enctype="multipart/form-data">

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="name"
                                    autofocus
                                    value="{!! $item->name ?? '' !!}"
                                    label="Name"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="address"
                                    value="{{ $item->address ?? '' }}"
                                    label="Address"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="rating"
                                    type="number"
                                    step="0.1"

                                    value="{{ $item->rating ?? '' }}"
                                    label="Rating"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="phone"
                                    value="{{ $item->phone ?? '' }}"
                                    label="Phone"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="website"
                                    value="{{ $item->website ?? '' }}"
                                    label="Website"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.select
                                    name="state_code"
                                    label="State Code {{ $item->state_code }}">
                                    <option value="">Select State</option>
                                    @foreach($states as $key => $item)
                                        <option
                                            value="{{$key}}" {{ ($item->state_code ?? '') == $key ? 'selected': '' }}>{{ ucwords($item) }}
                                            ({{strtoupper($key)}})
                                        </option>
                                    @endforeach
                                </x-avored::form.select>
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
                                <img src="{{ $item->media_upload['url'] ?? '' }}" alt=""/>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex">
                        <button type="submit"
                                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                            Update
                        </button>

                        <x-avored::link url="{{ route('admin.map-data.index', ['type' => $type]) }}" class="ml-3"
                                        style="button-default">
                            Cancel
                        </x-avored::link>
                    </div>
                </x-avored::form.form>
            </div>
        </div>

    </div>

</x-avored::layout>
