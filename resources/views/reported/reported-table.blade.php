<x-avored::table>
    <x-slot name="header">
        <x-avored::table.row class="bg-gray-300">
            <x-avored::table.header>
                ID
            </x-avored::table.header>
            <x-avored::table.header>
                Reported by User
            </x-avored::table.header>
            <x-avored::table.header>
                Reason
            </x-avored::table.header>
            <x-avored::table.header>
                Actions
            </x-avored::table.header>
        </x-avored::table.row>
    </x-slot>
    <x-slot name="body">
        @foreach ($report_list as $item)
            <x-avored::table.row class="">
                <x-avored::table.cell>
                    {{ $item->id }}
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->user->name }} ({{$item->user->email}})
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->reason }}
                </x-avored::table.cell>

                <x-avored::table.cell>
                    <div class="flex">
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
