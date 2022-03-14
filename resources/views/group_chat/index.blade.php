<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Group Chat
                </h2>
                <span class="ml-auto">
                <x-avored::link url="{{ route('admin.group-chat.create') }}" style="button-primary">
                    Create
                </x-avored::link>
            </span>
            </div>

            <div class="w-full mt-5">
                {{ $list->render() }}

                <div class="overflow-x-auto">
                    <x-avored::table>
                        <x-slot name="header">
                            <x-avored::table.row class="bg-gray-300">
                                <x-avored::table.header>
                                    Group Id
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Title
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
                                        {{ $item->title }}
                                    </x-avored::table.cell>

                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <x-avored::link url="{{ route('admin.group-chat.edit', $item) }}">
                                                <i class="w-5 h-5" data-feather="edit"></i>
                                            </x-avored::link>
                                            <x-avored::form.form action="{{ route('admin.group-chat.destroy', $item) }}"
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
