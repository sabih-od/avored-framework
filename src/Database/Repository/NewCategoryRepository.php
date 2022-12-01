<?php

namespace AvoRed\Framework\Database\Repository;

use App\Models\_Category;
use AvoRed\Framework\Catalog\Requests\RecipeRequest;
use AvoRed\Framework\Database\Contracts\NewCategoryModelInterface;
use AvoRed\Framework\Database\Models\Recipe;
use AvoRed\Framework\Database\Contracts\RecipeModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class NewCategoryRepository extends BaseRepository implements NewCategoryModelInterface
{
    use FilterTrait;

    /**
     * Filterable Fields
     * @var array $filterType
     */
    protected $filterFields = [
        'name',
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
        $this->model = new _Category();
    }


    /**
     * Get all the Recipes from the connected database.
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection $Recipes
     */
    public function getAllWithoutVaiation(int $perPage = 10): LengthAwarePaginator
    {
//        return Recipe::withoutVariation()->paginate($perPage);
        return _Category::paginate($perPage);
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
        $categories = _Category::paginate();

        return $categories;
    }
}
