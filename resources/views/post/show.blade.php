<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Post
                </h2>

            </div>

            <div class="mt-5 w-full">
                <label for="" class="text-gray-600 font-semibold block">Title</label>
                <p class="text-gray-600 mb-4">{{ $post->title }}</p>

                <label for="" class="text-gray-600 font-semibold block">Content</label>
                <p class="text-gray-600 mb-4">{{ $post->content }}</p>

                <label for="" class="text-gray-600 font-semibold block">Created At</label>
                <p class="text-gray-600 mb-4">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
            </div>
        </div>

        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Comments ({{ $post->comments()->count() }})
                </h2>

            </div>

            <div class="mt-5 w-full">
                @forelse($post->comments as $comment)
                    <div class="comentSection flex border-b-2 pb-2 mb-4">
                        <span>
                            <img class="img-fluid rounded-circle w-14 h-14 mr-2"
                                 src="{{ url('storage/uploads/'.$comment->user->profile_image) }}" alt="img"
                                 onerror="event.target.src=`{{ url('assets/images/ph-avatar.jpg') }}`">
                        </span>
                        <div>
                            <small class="text-gray-500 font-bold capitalize">{{ $comment->user->name }}</small>
                            <p>{{ $comment->comment }}</p>
                            <small>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                            <x-avored::form.form
                                    action="{{ route('admin.post-comment.destroy', ['post' => $post->id, 'comment' => $comment->id]) }}"
                                    method="DELETE">
                                <button class="bg-red-500 text-white px-2 py-1 rounded shadow-sm hover:bg-red-600 text-xs"
                                        type="submit">Delete
                                </button>
                            </x-avored::form.form>
                        </div>
                    </div>
                @empty
                    <p>No Comments</p>
                @endforelse
            </div>
        </div>

    </div>

</x-avored::layout>
