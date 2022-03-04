<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Database\Models\OrderStatus;
use AvoRed\Framework\Database\Contracts\OrderStatusModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Collection;

class OrderStatusRepository extends BaseRepository implements OrderStatusModelInterface
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
     * @var OrderStatus $model
     */
    protected $model;

    /**
     * Construct for the OrderStatus Repository
     */
    public function __construct()
    {
        $this->model = new OrderStatus();
    }

    /**
     * Get the model for the repository
     * @return OrderStatus
     */
    public function model(): OrderStatus
    {
        return $this->model;
    }

    /**
     * Find OrderStatus Resource into a database.
     * @param int $id
     * @return \AvoRed\Framework\Database\Models\OrderStatus $orderStatus
     */
    public function findDefault(): OrderStatus
    {
        return OrderStatus::whereIsDefault(1)->first();
    }

    /**
     * Update existing is default status to zero so new one can be marked
     *
     * @return bool
     */
    public function updateDefaultOrderStatusToNull(): bool
    {
        return OrderStatus::whereIsDefault(1)->update(['is_default' => 0]);
    }

    public function getUnpaidStatus()
    {
        $pendingStatus = null;
        $pendingStatus = OrderStatus::where('name', 'unpaid')->latest()->first();
        if(is_null($pendingStatus)) {
            $pendingStatus = OrderStatus::create([
                'name' => 'unpaid'
            ]);
        }

        return $pendingStatus;
    }

    public function getPendingStatus()
    {
        $pendingStatus = null;
        $pendingStatus = OrderStatus::where('name', 'pending')->latest()->first();
        if(is_null($pendingStatus)) {
            $pendingStatus = OrderStatus::create([
                'name' => 'pending'
            ]);
        }

        return $pendingStatus;
    }

    public function getCompleteStatus()
    {
        $completeStatus = null;
        $completeStatus = OrderStatus::where('name', 'complete')->latest()->first();
        if(is_null($completeStatus)) {
            $completeStatus = OrderStatus::create([
                'name' => 'complete'
            ]);
        }

        return $completeStatus;
    }
}
