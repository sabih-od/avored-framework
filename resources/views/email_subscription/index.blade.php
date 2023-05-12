<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Email Subscriptions
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
                                    Email
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
                                        {{ $item->email }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <x-avored::form.form
                                                action="{{ route('admin.email-subscription.destroy',  $item) }}"
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
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-avored::layout>
