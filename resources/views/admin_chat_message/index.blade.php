<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Admin Chat Messages
                </h2>
                <span class="ml-auto">
                <x-avored::link url="{{ route('admin.admin-chat-message.create') }}" style="button-primary">
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
                                    Id
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Messages
                                </x-avored::table.header>
                                <!-- <x-avored::table.header class="rounded-tr">
                                    Actions
                                </x-avored::table.header> -->
                            </x-avored::table.row>
                        </x-slot>
                        <x-slot name="body">
                            @forelse ($list as $item)
                                <x-avored::table.row class="">
                                    <x-avored::table.cell>
                                        {{ $item->id }}
                                    </x-avored::table.cell>

                                    <x-avored::table.cell>
                                        {{ $item->content }}
                                    </x-avored::table.cell>
                                    {{--
                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <!-- <x-avored::link url="{{ route('admin.admin-chat-message.edit', $item) }}">
                                                <i class="w-5 h-5" data-feather="edit"></i>
                                            </x-avored::link> -->
                                            <x-avored::form.form action="{{ route('admin.admin-chat-message.destroy', $item) }}"
                                                                 method="DELETE">
                                                <button type="submit">
                                                    <i class="w-5 h-5" data-feather="trash-2"></i>
                                                </button>
                                            </x-avored::form.form>
                                        </div>
                                    </x-avored::table.cell>--}}

                                </x-avored::table.row>
                            @empty
                                <x-avored::table.row>
                                    <x-avored::table.cell>No Messages</x-avored::table.cell>
                                    <x-avored::table.cell></x-avored::table.cell>
                                </x-avored::table.row>
                            @endforelse
                        </x-slot>
                    </x-avored::table>
                </div>
            </div>
        </div>
    </div>
</x-avored::layout>
