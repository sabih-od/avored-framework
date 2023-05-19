<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Equipment Videos
                </h2>
                <span class="ml-auto">
                <x-avored::link url="{{ route('admin.equipment.videos.create', $model_id) }}" style="button-primary">
                    Create
                </x-avored::link>
            </div>

            <div class="w-full mt-5">
                <!-- component -->
                <div class="overflow-x-auto">
                    <x-avored::table>
                        <x-slot name="header">
                            <x-avored::table.row class="bg-gray-300">
                                <x-avored::table.header>
                                    ID
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Name
                                </x-avored::table.header>
                                <x-avored::table.header class="rounded-tr">
                                    Actions
                                </x-avored::table.header>
                            </x-avored::table.row>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($items as $item)
                                <x-avored::table.row class="">
                                    <x-avored::table.cell>
                                        {{ $item->id }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $item->name }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <x-avored::link
                                                url="{{ route('admin.equipment.videos.edit', [$model_id, $item->id]) }}"
                                                class=" ml-3"
                                                title="Edit">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </x-avored::link>
                                            <x-avored::form.form
                                                action="{{ route('admin.equipment.videos.destroy',  [$model_id, $item->id]) }}"
                                                method="DELETE">
                                                <button class=" ml-3"
                                                        title="Delete"
                                                        type="submit"><i class="fa fa-trash"></i>
                                                </button>
                                            </x-avored::form.form>
                                        </div>
                                    </x-avored::table.cell>
                                </x-avored::table.row>
                            @endforeach
                        </x-slot>
                    </x-avored::table>

                    <div class="w-full">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-avored::layout>
