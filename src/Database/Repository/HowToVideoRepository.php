<?php

namespace AvoRed\Framework\Database\Repository;

use App\Models\HowToVideo;
use AvoRed\Framework\Database\Contracts\HowToVideoModelInterface;

class HowToVideoRepository extends BaseRepository implements HowToVideoModelInterface
{
    /**
     * @var HowToVideo
     */
    protected $model;

    /**
     * Construct for the Post Repository
     *
     */
    public function __construct()
    {
        $this->model = new HowToVideo();
    }

    /**
     * @return HowToVideo
     */
    public function model()
    {
        return $this->model;
    }

    public function list()
    {
        $videos = $this->model::paginate();
        return $videos;
    }
}
