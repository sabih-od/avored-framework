<?php

namespace AvoRed\Framework\MapData\Controllers;

use App\Models\GroupChat;
use App\Models\MapData;
use AvoRed\Framework\Database\Contracts\ChannelModelInterface;
use AvoRed\Framework\Database\Contracts\MapDataModelInterface;
use AvoRed\Framework\Database\Repository\MapDataRepository;
use AvoRed\Framework\MapData\Requests\CreateRequest;
use AvoRed\Framework\MapData\Requests\UpdateRequest;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MapDataController extends Controller
{
    /**
     * @var MapDataModelInterface|MapDataRepository
     */
    protected $repository;

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
     * @param MapData $map_datum
     * @return Response
     */
    public function edit(MapData $map_datum)
    {
        $item = $map_datum;
        $type = $item->map_data_type;
        $states = MapData::$states;
        return view('avored::map_data.edit', compact('type', 'states', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param MapData $map_datum
     * @return Response
     */
    public function update(UpdateRequest $request, MapData $map_datum)
    {
        $map_datum->update($request->only([
            'name',
            'address',
            'rating',
            'phone',
            'website',
            'state_code'
        ]));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $map_datum->clearMediaCollection('group_chat_upload');
            $map_datum->addMediaFromRequest('image')->toMediaCollection('map_data_upload');
        }

        return redirect(route('admin.map-data.index', ['type' => $map_datum->map_data_type]));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param MapData $map_datum
     * @return \Illuminate\Http\Response
     */
    public function destroy(MapData $map_datum)
    {
        $map_datum->clearMediaCollection('map_data_upload');
        $map_datum->delete();
        return redirect(route('admin.map-data.index', ['type' => $map_datum->map_data_type]));
    }

    private function getTypeInUrl()
    {
        $types = collect(MapData::$TYPES);
        $type = strtolower(request()->get('type', 'ranches'));
        if (!$types->contains($type))
            $type = $types->first();
        return $type;
    }
}
