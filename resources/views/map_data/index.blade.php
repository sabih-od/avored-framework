 <x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    {{ ucwords(str_replace("_", " ", $type)) }} Map Data
                </h2>
                <span class="ml-auto">
                <x-avored::link url="{{ route('admin.map-data.create', ['type' => $type]) }}"
                                style="button-primary">
                    Create
                </x-avored::link>
            </span>
            </div>
            <div class="w-1/3 ">
                <div class="mt-3 " >

                    <x-avored::form.form action="{{ route('admin.map-data.search') }} " style="display: flex;align-items: center;gap: 0 1.25rem; " class=""
                                         method="Post">
                        <x-avored::form.input
                            name="search"
                            autofocus
                            value=""

                        ></x-avored::form.input>
                        <button type="submit" style="">
                            Search
                        </button>
                        <x-avored::link url="{{ route('admin.map-data.index', ['type' => $type]) }} "  style="button-primary">
                            Cancel
                        </x-avored::link>
                    </x-avored::form.form>

                </div>
            </div>
            <div class="w-full mt-5">
                {{ $list->render() }}

                <div class="overflow-x-auto">
                    <x-avored::table
                    >
                        <x-slot name="header">
                            <x-avored::table.row class="bg-gray-300">
                                <x-avored::table.header>
                                    ID
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Name
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    State Code
                                </x-avored::table.header>
                                <x-avored::table.header class="rounded-tr">
                                    Actions
                                </x-avored::table.header>
                            </x-avored::table.row>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($list as $item)
                                <x-avored::table.row class="">
                                    <x-avored::table.cell>
                                        {{ $item->id }}
                                    </x-avored::table.cell>

                                    <x-avored::table.cell>
                                        {{ $item->name }}
                                    </x-avored::table.cell>

                                    <x-avored::table.cell>
                                        {{ strtoupper($item->state_code) }}
                                    </x-avored::table.cell>

                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <x-avored::link url="{{ route('admin.map-data.edit', $item) }}">
                                                <i class="w-5 h-5" data-feather="edit"></i>
                                            </x-avored::link>
                                            <x-avored::form.form action="{{ route('admin.map-data.destroy', $item) }}"
                                                                 method="DELETE">
                                                <button type="submit">
                                                    <i class="w-5 h-5" data-feather="trash-2"></i>
                                                </button>
                                            </x-avored::form.form>
                                        </div>
                                    </x-avored::table.cell>

                                </x-avored::table.row>
                            @endforeach
                        </x-slot>
                    </x-avored::table>
                </div>
            </div>
        </div>
    </div>
</x-avored::layout>
