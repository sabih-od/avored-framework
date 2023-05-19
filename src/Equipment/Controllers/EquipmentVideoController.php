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

        return view('avored::equipment.videos.edit', compact('model_id', 'item'));
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

        if ($request->hasFile('video')) {
            $equipment = Equipment::findOrFail($id);
            $item->delete();
            $video = $equipment->addMediaFromRequest('video')->toMediaCollection('equipment_videos');
            $video->name = $data['title'];
            $video->save();
        } else {
            $item->name = $data['title'];
            $item->save();
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
