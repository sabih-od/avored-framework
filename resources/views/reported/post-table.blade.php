<x-avored::table>
    <x-slot name="header">
        <x-avored::table.row class="bg-gray-300">
            <x-avored::table.header>
                Post ID
            </x-avored::table.header>
            <x-avored::table.header>
                Content
            </x-avored::table.header>
            @include('avored::reported.reported-count-header')
            @if(!$is_query)
                <x-avored::table.header class="rounded-tr">
                    Actions
                </x-avored::table.header>
            @endif
        </x-avored::table.row>
    </x-slot>
    <x-slot name="body">
        @foreach ($data as $item)
            <x-avored::table.row class="">
                <x-avored::table.cell>
                    {{ $item->id }}
                </x-avored::table.cell>
                <x-avored::table.cell>
                    {{ $item->content }}
                </x-avored::table.cell>
                @include('avored::reported.reported-count-cell')

                @if(!$is_query)
                    <x-avored::table.cell>
                        @include('avored::reported.model-item-actions')
                    </x-avored::table.cell>
                @endif

            </x-avored::table.row>
        @endforeach
    </x-slot>
</x-avored::table>
