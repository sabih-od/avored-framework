<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Edit Equipment
                </h2>

            </div>

            <div class="mt-5 w-full">
                <x-avored::form.form action="{{ route('admin.equipment.update', $equipment) }}" method="PUT"
                                     enctype="multipart/form-data">

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                        name="title"
                                        autofocus
                                        value="{!! $equipment->title ?? '' !!}"
                                        label="Title"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <textarea
                                        class="avored-input"
                                        rows="5"
                                        name="content"
                                        label="Content"
                                >{{ $equipment->content ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                        name="image"
                                        type="file"
                                        label="Image"
                                ></x-avored::form.input>
                                <img src="{{ $equipment->media_upload['url'] ?? '' }}" alt=""/>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex">
                        <button type="submit"
                                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                            Update
                        </button>

                        <x-avored::link url="{{ route('admin.equipment.index') }}" class="ml-3" style="button-default">
                            Cancel
                        </x-avored::link>
                    </div>
                </x-avored::form.form>
            </div>
        </div>

        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Equipment Reviews
                </h2>

            </div>

            <div class="mt-5 w-full">
                @forelse($equipment->reviews as $review)
                    <div class="userReview mb-3">
                        <img src="{{ url('storage/uploads/'.$review->user->profile_image) }}"
                             onerror="event.target.src=`{{ url('assets/images/ph-avatar.jpg') }}`"
                             class="img-fluid rounded-circle" alt="img">
                        <div class="reviewContent">
                            <h5>{{ $review->user->name }}
                                – {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }} </h5>
                            <div class="stars">
                                <span class="fa fa-star {{ $review->rating >= 1 ? 'checked': 'd-none' }}"></span>
                                <span class="fa fa-star {{ $review->rating >= 2 ? 'checked': 'd-none' }}"></span>
                                <span class="fa fa-star {{ $review->rating >= 3 ? 'checked': 'd-none' }}"></span>
                                <span class="fa fa-star {{ $review->rating >= 4 ? 'checked': 'd-none' }}"></span>
                                <span class="fa fa-star {{ $review->rating == 5 ? 'checked': 'd-none' }}"></span>
                            </div>
                            <p>{{ $review->content }}</p>
                            <x-avored::form.form action="{{ route('admin.equipment-review.delete', $review->id) }}"
                                                 method="DELETE">
                                <button class="bg-red-500 text-white px-2 py-1 rounded shadow-sm hover:bg-red-600 text-xs"
                                        type="submit">Delete
                                </button>
                            </x-avored::form.form>
                        </div>
                    </div>
                @empty
                    <p>No Reviews</p>
                @endforelse
            </div>
        </div>

    </div>

</x-avored::layout>
