<?php

namespace AvoRed\Framework\Database\Repository;

use App\Models\User;
use AvoRed\Framework\Database\Contracts\UserModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserModelInterface
{
    use FilterTrait;

    /**
     *
     * @var User $model
     */
    protected $model;

    /**
     * Construct for the Produdct Repository
     *
     */
    public function __construct()
    {
        $this->model = new User();
    }


    /**
     * Model object for the repository
     * @return User $model
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function list()
    {
        $users = $this->model::paginate();

        return $users;
    }
}
