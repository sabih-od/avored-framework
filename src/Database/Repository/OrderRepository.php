<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Database\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use AvoRed\Framework\Database\Contracts\OrderModelInterface;
use AvoRed\Framework\Database\Traits\FilterTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class OrderRepository extends BaseRepository implements OrderModelInterface
{
    use FilterTrait;

    /**
     * Filterable Fields
     * @var array $filterType
     */
    protected $filterFields = [
        'shipping_option',
        'payment_option',
    ];

    /**
     * @var Order $model
     */
    protected $model;

    /**
     * Construct for the Order Repository
     */
    public function __construct()
    {
        $this->model = new Order();
    }

    /**
     * Get the model for the repository
     * @return Order
     */
    public function model(): Order
    {
        return $this->model;
    }

    public function list()
    {
        $order = Order::with([
            'orderStatus', 
            'customer', 
            'shippingAddress', 
            'billingAddress', 
            'products'
        ])->paginate();

        return $order;
    }

    public function single($id)
    {
        return Order::whereId($id)
        ->with([
            'shippingAddress',
            'billingAddress',
            'orderStatus', 
            'customer', 
            'shippingAddress', 
            'billingAddress', 
            'products.product'
        ])
        ->paginate();
    }

    /**
     * Find Orders of a given user Id.
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Collection $userOrders
     */
    public function findByCustomerId(string $id) : LengthAwarePaginator
    {
        return Order::whereCustomerId($id)->paginate();
    }

    /**
     * Get no of  order by given month
     * @return int $totalOrders
     */
    public function getCurrentMonthTotalOrder() : int
    {
        $firstDay = $this->getFirstDay();
        $totalOrder = Order::select('id')->where('created_at', '>', $firstDay)->count();

        return $totalOrder;
    }
    /**
     * Get Total Revenue of current month
     * @return int $totalOrders
     */
    public function getCurrentMonthTotalRevenue() : float
    {
        $total = 0;
        $firstDay = $this->getFirstDay();
        $orders = Order::with('products')
            ->select('*')
            ->where('created_at', '>', $firstDay)
            ->get();

        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $total += ($product->qty * $product->price) + $product->tax_amount;
            }
        }

        return $total;
    }

    private function getFirstDay()
    {
        $startDay = Carbon::now();
        return $startDay->firstOfMonth();
    }

    public function updateOrderStatusWhenPaid($orderId, $orderCompleteStatusId, $orderUnpaidStatusId)
    {
        return Order::whereId($orderId)
                    ->where( 'order_status_id', '<>', $orderUnpaidStatusId )
                    ->update([
                        'order_status_id' => $orderCompleteStatusId
                    ]);
    }

    public function filter($data)
    {
        $filterOrders = $this->model;

        if( !is_null($data->order_id) ) {
            $filterOrders = $filterOrders->whereId($data->order_id);
        }

        if( !is_null($data->date_from) && !is_null($data->date_to)  ) {
            $fromDate = (new Carbon($data->date_from))->startOfDay()->toDateTimeString(); 
            $endDate = (new Carbon($data->date_to))->endOfDay()->toDateTimeString(); 
            
            $filterOrders = $filterOrders->whereBetween('created_at', [$fromDate, $endDate ]);
        }

        if( !is_null($data->order_status) ) {
            $filterOrders = $filterOrders->whereHas('orderStatus', function($query) use ($data){
                $query->where('name',  $data->order_status);
            });
        }

        if( !is_null($data->name) ) {
            $filterOrders = $filterOrders->whereHas('customer', function($query) use ($data){
                $query->where('first_name', 'like',  $data->name.'%')->orWhere('last_name', 'like', $data->name.'%');
            });
        }

        if( !is_null($data->email) ) {
            $filterOrders = $filterOrders->whereHas('customer', function($query) use ($data){
                $query->where('email',  $data->email);
            });
        }

        return $filterOrders->with([
            'orderStatus', 
            'customer', 
            'shippingAddress', 
            'billingAddress', 
            'products'
        ])->paginate();
    }
}
