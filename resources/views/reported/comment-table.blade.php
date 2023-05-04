<x-avored::table>
    <x-slot name="header">
        <x-avored::table.row class="bg-gray-300">
            <x-avored::table.header>
                Comment ID
            </x-avored::table.header>
            <x-avored::table.header>
                Comment
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
                    {{ $item->comment }}
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->reported_count }}
                </x-avored::table.cell>

                <x-avored::table.cell>
                    <div class="flex">
{{--                        @if(array_search($item->reportable_type, \App\Http\Requests\ReportedCreateRequest::types()) === 'user')--}}
{{--                            <x-avored::link url="#" title="Deactivate User">--}}
{{--                                <i class="fa fa-ban" aria-hidden="true"></i>--}}
{{--                            </x-avored::link>--}}
{{--                        @endif--}}
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
