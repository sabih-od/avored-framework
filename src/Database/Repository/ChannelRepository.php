<?php

namespace AvoRed\Framework\Database\Repository;

use App\Models\Channel;
use AvoRed\Framework\Database\Contracts\ChannelModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;

class ChannelRepository extends BaseRepository implements ChannelModelInterface
{
    use FilterTrait;

    /**
     * @var Channel
     */
    protected $model;

    /**
     * Construct for the Produdct Repository
     *
     */
    public function __construct()
    {
        $this->model = new Channel();
    }


    /**
     * @return GroupChat
     */
    public function model()
    {
        return $this->model;
    }

}
