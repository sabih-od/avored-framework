<x-avored::layout>
    <div>
        <div class="p-5">
            <div class="flex w-full">
                <h2 class="text-2xl text-red-700 font-semibold">
                    Edit
                </h2>

            </div>

            <div class="mt-5 w-full">
                <x-avored::form.form action="{{ route('admin.equipment.videos.update', [$model_id, $item->id]) }}"
                                     method="PUT"
                                     enctype="multipart/form-data">

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="title"
                                    autofocus
                                    value="{{ old('title') ?? $item->name }}"
                                    label="Title"
                                ></x-avored::form.input>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <x-avored::form.input
                                    name="video"
                                    type="file"
                                    label="Video"
                                ></x-avored::form.input>
                                @if(($item->getUrl() ?? ''))
                                    <video id="videoElement" controls src="{{ $item->getUrl() ?? '' }}"
                                           alt=""/>
                                @endif
                            </div>
                        </div>
                        <div class="w-1/2" style="display: flex; align-items: flex-end ; padding: 10px 10px 0px 10px">
                        
                            @if($thumbnail_img)

                                <button
                                    style="background-color: #7f8c8d ;"
                                    type="button"
                                    id="removeThumbnail"
                                    class="flex ml-2 justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:shadow-outline-red">
                                    Remove Thumbnail
                                </button>

                            @endif

                            <button
                                style="background-color: #7f8c8d ; display: none"
                                type="button"
                                id="removeThumbnail"
                                class="flex ml-2 justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:shadow-outline-red">
                                Remove Thumbnail
                            </button>

                            <button
                                type="button"
                                id="setThumbnail"
                                class="flex justify-center ml-2 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                                Set Thumbnail
                            </button>
                        </div>
                    </div>

                    <input type="hidden" name="video_thumbnail" id="videoThumbnail"
                           value="{{ $thumbnail_img ? '1': null }}">

                    @if($thumbnail_img)
                        <img id="thumbPreview" style="width: 20%; margin-top: 2%" src="{{ $thumbnail_img }}"
                             alt=""/>
                    @endif

                    <!-- <div class="flex w-full">
                        <div class="w-1/2">
                            <div class="mt-3">
                                <video src="{{ $item->getUrl() }}" controls></video>
                            </div>
                        </div>
                    </div> -->

                    <div class="mt-6 flex">
                        <button type="submit"
                                class="flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700">
                            Update
                        </button>

                        <x-avored::link url="{{ route('admin.equipment.videos.index', $model_id) }}" class="ml-3" style="button-default">
                            Cancel
                        </x-avored::link>
                    </div>
                </x-avored::form.form>
            </div>
        </div>

    </div>

</x-avored::layout>

<script>

    const video = document.getElementById('videoElement');
    const thumbnailBtn = document.getElementById('setThumbnail');

    // Hide the button initially
    thumbnailBtn.style.display = 'none';

    video.addEventListener('play', function () {
        // Hide the button when the video is playing
        thumbnailBtn.style.display = 'none';
    });

    video.addEventListener('pause', function () {
        // Show the button when the video is paused
        thumbnailBtn.style.display = 'block';
    });

    video.addEventListener('ended', function () {
        // Show the button when the video ends
        thumbnailBtn.style.display = 'block';
    });

    document.getElementById('setThumbnail').addEventListener('click', function () {
        // Assuming you have a video element with an ID 'videoElement'
        const video = document.getElementById('videoElement');
        const thumnailBtn = document.getElementById('setThumbnail');
        const removeThumnBtn = document.getElementById('removeThumbnail');
        // Create a canvas to draw the video frame
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw the video frame on the canvas
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        // Get the image data as a URL
        const imageDataUrl = canvas.toDataURL('image/png');
        // console.log("imageDataUrl", imageDataUrl)

        // Set the image data in the hidden input
        document.getElementById('videoThumbnail').value = imageDataUrl;

        if (imageDataUrl) {
            thumnailBtn.style.display = 'none';
            removeThumnBtn.style.display = 'block';
        }

    });

    document.getElementById('removeThumbnail').addEventListener('click', function () {

        const videoThumbnailInput = document.getElementById('videoThumbnail');
        videoThumbnailInput.value = '';

        const thumbPreview = document.getElementById('thumbPreview')
        if (thumbPreview)
            thumbPreview.remove()

        // console.log("videoThumbnailInput", videoThumbnailInput.value)
        // Hide the "Remove Thumbnail" button
        document.getElementById('removeThumbnail').style.display = 'none';

        // Show the "Set Thumbnail" button
        document.getElementById('setThumbnail').style.display = 'block';

    });


</script>