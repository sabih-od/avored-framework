<x-avored::table>
    <x-slot name="header">
        <x-avored::table.row class="bg-gray-300">
            <x-avored::table.header>
                User ID
            </x-avored::table.header>
            <x-avored::table.header>
                Name
            </x-avored::table.header>
            <x-avored::table.header>
                Email
            </x-avored::table.header>
            <x-avored::table.header>
                Total Reported
            </x-avored::table.header>
            <x-avored::table.header class="rounded-tr">
                Actions
            </x-avored::table.header>
        </x-avored::table.row>
    </x-slot>
    <x-slot name="body">
        @foreach ($data as $item)
            <x-avored::table.row class="">
                <x-avored::table.cell>
                    {{ $item->id }}
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->name }}
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->email }}
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->reported_count }}
                </x-avored::table.cell>

                <x-avored::table.cell>
                    <div class="flex">
                        <x-avored::link url="#" title="Delete User">
                            <i class="fa fa-ban" aria-hidden="true"></i>
                        </x-avored::link>
                        <x-avored::form.form action="{{ route('admin.reported.destroy', $item) }}"
                                             method="DELETE">
                            <button class=" ml-3"
                                    title="Clear Report"
                                    type="submit"><i class="fa fa-trash"></i>
                            </button>
                        </x-avored::form.form>
                    </div>
                </x-avored::table.cell>

            </x-avored::table.row>
        @endforeach
    </x-slot>
</x-avored::table>
