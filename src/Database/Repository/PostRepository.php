<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Database\Models\Post;
use AvoRed\Framework\Database\Contracts\PostModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends BaseRepository implements PostModelInterface
{
    /**
     * @var Post
     */
    protected $model;

    /**
     * Construct for the Post Repository
     *
     */
    public function __construct()
    {
        $this->model = new Post();
    }

    /**
     * @return Post
     */
    public function model()
    {
        return $this->model;
    }

    public function list()
    {
        $posts = $this->model::paginate();

        return $posts;
    }
}
