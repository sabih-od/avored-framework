<?php

namespace AvoRed\Framework\_Category\Controllers;

use App\Models\_Category;
use AvoRed\Framework\_Category\Requests\NewCategoryRequest;
use AvoRed\Framework\Database\Contracts\NewCategoryModelInterface;
use AvoRed\Framework\Database\Repository\NewCategoryRepository;
use AvoRed\Framework\Recipe\Requests\RecipeRequest;
use AvoRed\Framework\Database\Contracts\RecipeModelInterface;
use AvoRed\Framework\Database\Models\Recipe;
use AvoRed\Framework\Tab\Tab;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class NewCategoryController extends Controller
{

    /**
     * @var AvoRed\Framework\Database\Repository\RecipeRepository $categoryRepository
     */
    protected $categoryRepository;
    /**
     *
     * @param RecipeRepository $repository
     */
    public function __construct(
        NewCategoryRepository $repository
    ) {
        $this->categoryRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categories = $this->categoryRepository->paginate();
        $_categories = $this->categoryRepository->list();
        return view('avored::_category.index')->with('_categories', $_categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored::_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewCategoryRequest $request)
    {
        $_category = $this->categoryRepository->create($request->all());

        return redirect(route('admin.new_category.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(_Category $_category)
    {
        return view('avored::_category.edit')->with('_category', $_category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest  $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(NewCategoryRequest $request, _Category $_category)
    {

        $_category->update($request->all());

        return redirect(route('admin.new_category.index'));
    }

    /**
     * @param Recipe $category
     * @return mixed
     */
    public function destroy(_Category $_category)
    {
        $_category->delete();
        return redirect(route('admin.new_category.index'));
    }
}
