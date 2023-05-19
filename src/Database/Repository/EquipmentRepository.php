<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Database\Contracts\EquipmentModelInterface;
use AvoRed\Framework\Database\Models\Equipment;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class EquipmentRepository extends BaseRepository implements EquipmentModelInterface
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
        $this->model = new Equipment();
    }


    /**
     * Get all the Recipes from the connected database.
     * @param int $perPage
     * @return \Illuminate\Database\Eloquent\Collection $Recipes
     */
    public function getAllWithoutVaiation(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model::withoutVariation()->paginate($perPage);
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
        $list = $this->model::/*with([
            'user'
        ])->*/paginate();

        return $list;
    }
}
