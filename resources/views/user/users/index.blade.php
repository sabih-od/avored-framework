<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Users List
                </h2>
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
                                <x-avored::table.header>
                                    Email
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Is Lifetime
                                </x-avored::table.header>
                                <x-avored::table.header class="rounded-tr">
                                    Action
                                </x-avored::table.header>
                            </x-avored::table.row>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($users as $user)
                                <x-avored::table.row class="{{ ($loop->index % 2 == 0) ? '' : 'bg-gray-200'  }}">
                                    <x-avored::table.cell>
                                        {{ $user->id ?? '' }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $user->name ?? '' }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $user->email ?? '' }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $user->is_lifetime_access ? 'Yes': 'No' }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <x-avored::form.form action="{{ route('admin.users.destroy', $user) }}"
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
                    <div class="w-full">
                        {{ $users->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-avored::layout>
