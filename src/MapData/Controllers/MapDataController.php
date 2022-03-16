<?php

namespace AvoRed\Framework\MapData\Controllers;

use App\Models\GroupChat;
use App\Models\MapData;
use AvoRed\Framework\Database\Contracts\ChannelModelInterface;
use AvoRed\Framework\Database\Contracts\MapDataModelInterface;
use AvoRed\Framework\Database\Repository\MapDataRepository;
use AvoRed\Framework\MapData\Requests\CreateRequest;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MapDataController extends Controller
{
    /**
     * @var MapDataModelInterface|MapDataRepository
     */
    protected $repository;

    public static $TYPES = ['ranches', 'professional_hunting', 'taxidermy', 'processing'];

    /**
     *
     * @param MapDataRepository $repository
     */
    public function __construct(MapDataModelInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $type = $this->getTypeInUrl();
        $list = $this->repository->list($type);
        return view('avored::map_data.index', compact('type', 'list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $type = $this->getTypeInUrl();
        $states = MapData::$states;
        return view('avored::map_data.create', compact('type', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRequest $request
     * @return Response
     */
    public function store(CreateRequest $request)
    {
        $entry = $this->repository->create($request->only([
            'name',
            'address',
            'rating',
            'phone',
            'website',
            'state_code',
            'map_data_type'
        ]));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $entry->addMediaFromRequest('image')->toMediaCollection('map_data_upload');
        }

        return redirect(route('admin.map-data.index', ['type' => $request->map_data_type]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $mapData
     * @return Response
     */
    public function edit($mapData)
    {
        $item = $this->repository->find($mapData);
        if (is_null($item)) return redirect(route('admin.map-data.index'));
        $type = $item->map_data_type;
        $states = MapData::$states;
        return view('avored::map_data.edit', compact('type', 'states', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  $group
     * @return Response
     */
    public function update($request, $group_chat)
    {
        $group_chat->update($request->only(['title']));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $group_chat->clearMediaCollection('group_chat_upload');
            $group_chat->addMediaFromRequest('image')->toMediaCollection('group_chat_upload');
        }

        return redirect(route('admin.group-chat.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param $mapData
     * @return \Illuminate\Http\Response
     */
    public function destroy($mapData)
    {
        $data = $this->repository->find($mapData);
        if (is_null($data)) return redirect(route('admin.map-data.index'));
        $type = $data->map_data_type;
        $data->clearMediaCollection('map_data_upload');
        $data->delete();
        return redirect(route('admin.map-data.index', ['type' => $type]));
    }

    private function getTypeInUrl()
    {
        $types = collect(self::$TYPES);
        $type = strtolower(request()->get('type', 'ranches'));
        if (!$types->contains($type))
            $type = $types->first();
        return $type;
    }
}
