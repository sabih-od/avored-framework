<?php

namespace AvoRed\Framework\Equipment\Controllers;

use App\Models\Review;
use AvoRed\Framework\Database\Models\Equipment;
use AvoRed\Framework\Database\Repository\EquipmentRepository;
use AvoRed\Framework\Equipment\Requests\EquipmentCreateRequest;
use AvoRed\Framework\Equipment\Requests\EquipmentUpdateRequest;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;

class EquipmentVideoController extends Controller
{

    public function index(Request $request)
    {
        $model_type = Equipment::class;
        $model_id = $request->route("id");
        $items = Media::query()->where([
            ['model_type', $model_type],
            ['model_id', $model_id],
            ['collection_name', 'equipment_videos'],
        ])->paginate();

        return view('avored::equipment.videos.index', compact('items', 'model_id'));
    }

    public function create()
    {
        return view('avored::equipment.videos.create');
    }

    public function store(Request $request)
    {
        $id = $request->route('id');
        $equipment = Equipment::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|max:200',
            'video' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:102400'
        ]);

        $video = $equipment->addMediaFromRequest('video')->toMediaCollection('equipment_videos');
        $video->name = $data['title'];
        $video->save();

        return redirect(route('admin.equipment.videos.index', $id));
    }

    public function edit($id, $video_id)
    {
        $model_type = Equipment::class;
        $model_id = $id;
        
        $item = Media::query()->where([
            ['model_type', $model_type],
            ['model_id', $id],
            ['collection_name', 'equipment_videos'],
            ['id', $video_id]
        ])->first();

        if (is_null($item))
            return abort(404);

        $imagePath = $video_id.'/'.$item->thumbnail;
        $thumbnail_img = is_null($item->thumbnail) ? null : url(Storage::url($imagePath));

        return view('avored::equipment.videos.edit', compact('model_id', 'item', 'thumbnail_img'));
    }

    public function update(Request $request, $id, $video_id)
    {
        $data = $request->validate([
            'title' => 'required|max:200',
            'video' => 'sometimes|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:102400'
        ]);

        $model_type = Equipment::class;
        $item = Media::query()->where([
            ['model_type', $model_type],
            ['model_id', $id],
            ['collection_name', 'equipment_videos'],
            ['id', $video_id]
        ])->first();

        if (is_null($item))
            return abort(404);

        $equipment = Equipment::findOrFail($id);
        
        if ($request->hasFile('video')) {
            $fileName = $equipment->getFirstMedia('equipment_videos')->file_name;
            $filePath = $video_id.'/'.$fileName;

            if(Storage::disk('public')->exists($filePath)) Storage::disk('public')->delete($filePath);

            // Upload and store the new video
            $newVideo = $request->file('video');
            $newFileName = str_replace(' ', '-', $newVideo->getClientOriginalName()); // Use the original file name or generate a new one

            $newFilePath = $video_id . '/' . $newFileName;
            Storage::disk('public')->putFileAs($video_id, $newVideo, $newFileName);

            Media::query()->whereId($video_id)->update([
                'name' => $data['title'],
                'file_name' => $newFileName
            ]);

            // $item->delete();
            // $video = $equipment->addMediaFromRequest('video')->toMediaCollection('equipment_videos');
            // $video->name = $data['title'];
            // $video->save();
        } else {
            $item->name = $data['title'];
            $item->save();
        }

        if ($request->has('video_thumbnail')) {
            $fileName = $item->thumbnail;
            $filePath = $video_id.'/'.$fileName;
            
            if (empty($request->video_thumbnail)) {
                // dd('empty($request->video_thumbnail)');
            
                if(Storage::disk('public')->exists($filePath)) Storage::disk('public')->delete($filePath);
                $media = Media::whereId($video_id)->update([
                    'thumbnail' => null
                ]);
                
            } elseif($request->video_thumbnail !== '1') {
                // dd('$request->video_thumbnail !== "1"');
                
                if(Storage::disk('public')->exists($filePath)) Storage::disk('public')->delete($filePath);
                
                // Get the base64 image data from the request
                $base64Image = $request->input('video_thumbnail');

                // Remove the data URI scheme (e.g., 'data:image/jpeg;base64,') from the base64 string
                $base64Image = preg_replace('/^data:image\/(jpeg|png|gif);base64,/', '', $base64Image);

                // Generate a unique filename for the image
                $filename = uniqid() . '.' . 'jpg'; // You can change the file format based on your needs

                // Get the storage disk you want to save the image to (e.g., 'public')
                $disk = Storage::disk('public');

                // Specify the directory path within the storage disk where you want to save the image
                $directory = $video_id;

                // Build the full path to the image file
                $filePath = $directory . '/' . $filename;

                // Use file_put_contents to save the image
                $disk->put($filePath, base64_decode($base64Image));

                $media = Media::whereId($video_id)->update([
                    'thumbnail' => $filename
                ]);
            }
        }

        return redirect(route('admin.equipment.videos.index', $id));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $video_id)
    {
        $model_type = Equipment::class;
        $item = Media::query()->where([
            ['model_type', $model_type],
            ['model_id', $id],
            ['collection_name', 'equipment_videos'],
            ['id', $video_id]
        ])->first();

        if (is_null($item))
            return abort(404);

        $item->delete();

        return redirect(route('admin.equipment.videos.index', $id));
    }
}
