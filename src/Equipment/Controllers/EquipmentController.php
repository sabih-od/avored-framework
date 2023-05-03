<?php

namespace AvoRed\Framework\Equipment\Controllers;

use App\Models\Review;
use AvoRed\Framework\Database\Contracts\EquipmentModelInterface;
use AvoRed\Framework\Database\Contracts\ReviewModelInterface;
use AvoRed\Framework\Database\Models\Equipment;
use AvoRed\Framework\Database\Repository\EquipmentRepository;
use AvoRed\Framework\Equipment\Requests\EquipmentCreateRequest;
use AvoRed\Framework\Equipment\Requests\EquipmentUpdateRequest;
use Illuminate\Http\Response;
use \Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * @var EquipmentModelInterface|EquipmentRepository
     */
    protected $repository;

    protected $reviews;

    /**
     *
     * @param EquipmentRepository $repository
     */
    public function __construct(EquipmentModelInterface $repository, ReviewModelInterface $reviews)
    {
        $this->repository = $repository;
        $this->reviews = $reviews;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $equipment = $this->repository->list();
        return view('avored::equipment.index')->with('equipment', $equipment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('avored::equipment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EquipmentCreateRequest $request
     * @return Response
     */
    public function store(EquipmentCreateRequest $request)
    {
        $recipe = $this->repository->create($request->only(['title', 'content']));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $recipe->addMediaFromRequest('image')->toMediaCollection('equipment_upload');
        }

        return redirect(route('admin.equipment.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Equipment $equipment
     * @return Response
     */
    public function edit(Equipment $equipment)
    {
        $equipment = $equipment;
        $reviews = $equipment->reviews()->orderByDesc('created_at')->paginate(1);
        return view('avored::equipment.edit')->with(compact('equipment', 'reviews'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EquipmentUpdateRequest $request
     * @param Equipment $equipment
     * @return Response
     */
    public function update(EquipmentUpdateRequest $request, Equipment $equipment)
    {

        $equipment->update($request->only(['title', 'content']));

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $equipment->clearMediaCollection('equipment_upload');
            $equipment->addMediaFromRequest('image')->toMediaCollection('equipment_upload');
        }

        return redirect(route('admin.equipment.index'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $review->status = !$review->status;
        $review->save();
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {
        if (Auth::check())
            $equipment->delete();

        return redirect(route('admin.equipment.index'));
    }

    /**
     * @param $id
     */
    public function deleteReview($id)
    {
        $item = $this->reviews->find($id);
        if (Auth::check())
            $item->delete();

        return redirect(route('admin.equipment.edit', $item->reviewable_id));
    }
}
