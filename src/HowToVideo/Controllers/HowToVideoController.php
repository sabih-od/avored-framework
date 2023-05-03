<?php

namespace AvoRed\Framework\HowToVideo\Controllers;

use App\Models\HowToVideo;
use AvoRed\Framework\Database\Contracts\HowToVideoModelInterface;
use AvoRed\Framework\HowToVideo\Requests\CreateRequest;
use AvoRed\Framework\HowToVideo\Requests\UpdateRequest;
use \Illuminate\Routing\Controller;

class HowToVideoController extends Controller
{
    protected $repository;

    public function __construct(HowToVideoModelInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $list = $this->repository->list();
        return view('avored::how_to_video.index', compact('list'));
    }

    public function create()
    {
        return view('avored::how_to_video.create');
    }

    public function store(CreateRequest $request)
    {
        $data = $request->only([
            'title',
        ]);
        $data['status'] = 1;
        $entry = $this->repository->create($data);

        if ($request->hasFile('video') && $request->file('video')->isValid()) {
            $entry->addMediaFromRequest('video')->toMediaCollection('how_to_video_upload');
        }

        return redirect(route('admin.how-to-video.index'));
    }

    public function edit(HowToVideo $how_to_video)
    {
        $item = $how_to_video;
        return view('avored::how_to_video.edit', compact('item'));
    }

    public function update(UpdateRequest $request, HowToVideo $how_to_video)
    {
        $data = $request->only([
            'title'
        ]);
        $data['status'] = 0;
        if ($request->has('status')) {
            $data['status'] = 1;
        }
        $how_to_video->update($data);

        if ($request->hasFile('video') && $request->file('video')->isValid()) {
            $how_to_video->clearMediaCollection('how_to_video_upload');
            $how_to_video->addMediaFromRequest('video')->toMediaCollection('how_to_video_upload');
        }

        return redirect(route('admin.how-to-video.index'));
    }

    public function destroy(HowToVideo $how_to_video)
    {
        $how_to_video->clearMediaCollection('how_to_video_upload');
        $how_to_video->delete();
        return redirect(route('admin.how-to-video.index'));
    }
}
