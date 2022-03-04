<?php

namespace AvoRed\Framework\Recipe\Controllers;

use AvoRed\Framework\Recipe\Requests\RecipeRequest;
use AvoRed\Framework\Database\Contracts\RecipeModelInterface;
use AvoRed\Framework\Database\Models\Recipe;
use AvoRed\Framework\Tab\Tab;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{

    /**
     * @var AvoRed\Framework\Database\Repository\RecipeRepository $recipeRepository
     */
    protected $recipeRepository;
    /**
     *
     * @param RecipeRepository $repository
     */
    public function __construct(
        RecipeModelInterface $repository
    ) {
        $this->recipeRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $recipes = $this->recipeRepository->paginate();
        $recipes = $this->recipeRepository->list();
        return view('avored::recipe.index')->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('avored::recipe.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecipeRequest $request)
    {
        $recipe = $this->recipeRepository->create($request->all());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $recipe->clearMediaCollection('recipe_upload');
            $recipe->addMediaFromRequest('image')->toMediaCollection('recipe_upload');
        }

        return redirect(route('admin.recipe.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        return view('avored::recipe.edit')->with('recipe', $recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest  $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(RecipeRequest $request, Recipe $recipe)
    {

        $recipe->update($request->all());

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $recipe->clearMediaCollection('recipe_upload');
            $recipe->addMediaFromRequest('image')->toMediaCollection('recipe_upload');
        }

        return redirect(route('admin.recipe.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        
    }
}
