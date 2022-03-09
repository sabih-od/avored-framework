<?php

namespace AvoRed\Framework\Database\Repository;

use App\Models\Review;
use AvoRed\Framework\Database\Contracts\ReviewModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class ReviewRepository extends BaseRepository implements ReviewModelInterface
{

    /**
     *
     * @var \App\Models\Review $model
     */
    protected $model;

    /**
     * Construct for the Review Repository
     *
     */
    public function __construct()
    {
        $this->model = new Review();
    }


    /**
     * Model object for the repository
     * @return \App\Models\Review $model
     */
    public function model()
    {
        return $this->model;
    }
}
