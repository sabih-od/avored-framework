<?php

namespace AvoRed\Framework\Database\Repository;

use Illuminate\Database\Eloquent\Collection;
use App\Models\AdminChatMessage;
use AvoRed\Framework\Database\Contracts\AdminChatMessageModelInterface;

class AdminChatMessageRepository extends BaseRepository implements AdminChatMessageModelInterface
{
    
    /**
     * @var AdminChatMessage $model
     */
    protected $model;

    /**
     * Construct for the AdminChatMessage Repository
     */
    public function __construct()
    {
        $this->model = new AdminChatMessage();
    }

    /**
     * Get the model for the repository
     * @return AdminChatMessage
     */
    public function model(): AdminChatMessage
    {
        return $this->model;
    }

    public function list()
    {
        return $this->model::select('id', 'admin_user_id', 'content', 'created_at')->orderBy('created_at', 'DESC')->paginate();
    }

}