<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Review List
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
                                    Review
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Rating
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    User
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Product
                                </x-avored::table.header>
                                <x-avored::table.header>
                                    Status
                                </x-avored::table.header>
                                <x-avored::table.header class="rounded-tr">
                                    {{ __('avored::system.actions') }}
                                </x-avored::table.header>
                            </x-avored::table.row>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($reviews as $review)
                                <x-avored::table.row class="{{ ($loop->index % 2 == 0) ? '' : 'bg-gray-200'  }}">
                                    <x-avored::table.cell>
                                        {{ $review->id }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $review->comment }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $review->rating }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $review->user->name }}({{ $review->user->email }})
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        {{ $review->product->name }}
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        <a href="{{ route('admin.product-review.update-status', [$review, 'status' => !$review->status ? 'publish': 'unpublish']) }}"
                                           class="bg-blue-500 text-white font-bold py-2 px-2">
                                            {{ $review->status ? 'Published': 'Publish' }}
                                        </a>
                                    </x-avored::table.cell>
                                    <x-avored::table.cell>
                                        <div class="flex">
                                            <x-avored::link
                                                x-on:click.prevent="toggleConfirmationDialog(
                                                                                        true,
                                                                                        {{ $review }},
                                                                                        '{{ __('avored::system.confirmation_delete_message', ['attribute_value' => 'item', 'attribute' => 'product review']) }}',
                                                                                        '{{ route('admin.product-review.destroy', $review) }}'
                                                                                    )"
                                                url="{{ route('admin.product-review.destroy', $review) }}">
                                                <!-- <i class="w-5 h-5" data-feather="trash"></i> -->
                                                <i class="fa fa-trash"></i>
                                                <x-avored::form.form
                                                    id="product-destory-{{ $review->id }}"
                                                    method="delete"
                                                    action="{{ route('admin.product-review.destroy', $review) }}">
                                                </x-avored::form.form>
                                            </x-avored::link>
                                        </div>
                                    </x-avored::table.cell>
                                </x-avored::table.row>
                            @endforeach
                        </x-slot>
                    </x-avored::table>
                    <div class="w-full">
                        {{ $reviews->render() }}
                    </div>
                </div>
            </div>
        </div>
        <div x-show="showConfirmationModal"
             class="min-w-screen h-screen animated fadeIn faster  fixed  left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-no-repeat bg-center bg-cover"
             id="modal-id">
            <div class="absolute bg-black opacity-20 inset-0 z-0"></div>
            <div class="w-full  max-w-lg p-5 relative mx-auto my-auto rounded-xl shadow-lg  bg-white ">
                <!--content-->
                <div class="">
                    <!--body-->
                    <div class="text-center p-5 flex-auto justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                fill-rule="evenodd"
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"/>
                        </svg>
                        <h3 class="text-xl font-bold py-4 ">
                            {{ __('avored::system.are_you_sure') }}
                        </h3>
                        <p class="text-sm text-gray-500 px-8" x-html="message">


                        </p>
                    </div>
                    <!--footer-->
                    <div class="p-3  mt-2 text-center space-x-4 md:block">
                        <button x-on:click="toggleConfirmationDialog(false)"
                                class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                            {{ __('avored::system.cancel') }}
                        </button>
                        <button x-on:click="confirmation"
                                class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600">
                            {{ __('avored::system.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-avored::layout>
