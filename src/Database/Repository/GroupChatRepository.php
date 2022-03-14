<?php

namespace AvoRed\Framework\Database\Repository;

use App\Models\GroupChat;
use AvoRed\Framework\Database\Contracts\GroupChatModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;

class GroupChatRepository extends BaseRepository implements GroupChatModelInterface
{
    use FilterTrait;

    /**
     * @var GroupChat
     */
    protected $model;

    /**
     * Construct for the Produdct Repository
     *
     */
    public function __construct()
    {
        $this->model = new GroupChat();
    }


    /**
     * @return GroupChat
     */
    public function model()
    {
        return $this->model;
    }

    public function list()
    {
        return $this->model::paginate();
    }
}
