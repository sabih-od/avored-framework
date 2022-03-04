<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Catalog\Requests\RecipeRequest;
use AvoRed\Framework\Database\Models\Recipe;
use AvoRed\Framework\Database\Contracts\RecipeModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeRepository extends BaseRepository implements RecipeModelInterface
{
    use FilterTrait;

    /**
     * Filterable Fields
     * @var array $filterType
     */
    protected $filterFields = [
        'name',
        'description'
    ];

    /**
     *
     * @var \AvoRed\Framework\Database\Models\Recipe $model
     */
    protected $model;

    /**
     * Construct for the Produdct Repository
     *
     */
    public function __construct()
    {
        $this->model = new Recipe();
    }


    /**
     * Get all the Recipes from the connected database.
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection $Recipes
     */
    public function getAllWithoutVaiation(int $perPage = 10): LengthAwarePaginator
    {
        return Recipe::withoutVariation()->paginate($perPage);
    }

    /**
     * Model object for the repository
     * @return \AvoRed\Framework\Database\Models\Recipe $model
     */
    public function model()
    {
        return $this->model;
    }

    public function list()
    {
        $recipes = Recipe::with([
            'user'
        ])->paginate();

        return $recipes;
    }
}
