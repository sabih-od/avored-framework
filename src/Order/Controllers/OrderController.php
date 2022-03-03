<?php

namespace AvoRed\Framework\Order\Controllers;

use AvoRed\Framework\Database\Contracts\OrderModelInterface;
use AvoRed\Framework\Database\Contracts\OrderStatusModelInterface;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    /**
     * @var OrderRepository $orderRepository
     */
    protected $orderRepository;
    /**
     *
     * @param OrderRepositroy $repository
     */
    public function __construct(
        OrderModelInterface $repository,
        OrderStatusModelInterface $orderStatusRepository
    ) {
        $this->orderRepository = $repository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderes = $this->orderRepository->list();
        
        return view('avored::order.order.index')
            ->with('orders', $orderes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderes = $this->orderRepository->single($id);
        // dd($orderes->toArray());
        return view('avored::order.order.single')
            ->with('orders', $orderes);
    }

    public function status(Request $request)
    {
        $validator= Validator::make($request->all(), [
            'status' => ['required', 'string'],
            'order_id' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            $fail("Some thing wrong!");
        }
        
        $inputs = $request->all();
        $status = $inputs['status'];
        $order_id = $inputs['order_id'];

        $order = null;
        $getUnpaidStatus = $this->orderStatusRepository->getUnpaidStatus();
        $orderUnpaidStatusId = $getUnpaidStatus['id'] ?? null;
        if(!is_null($getUnpaidStatus)) {
            if ( $status == 'pending' ) {
                $getPendingStatus = $this->orderStatusRepository->getPendingStatus();
                $orderPendingStatusId = $getPendingStatus['id'];
                $order = $this->orderRepository->updateOrderStatusWhenPaid($order_id, $orderPendingStatusId, $orderUnpaidStatusId);
            }
    
            if ( $status == 'complete' ) {
                $getCompleteStatus = $this->orderStatusRepository->getCompleteStatus();
                $orderCompleteStatusId = $getCompleteStatus['id'];
                $order = $this->orderRepository->updateOrderStatusWhenPaid($order_id, $orderCompleteStatusId, $orderUnpaidStatusId);
            }
        }
        
        $orderes = $this->orderRepository->list();
                return view('avored::order.order.index')
                ->with('orders', $orderes);
    }

    public function filter(Request $request)
    {
        $orderes = $this->orderRepository->filter($request);
        
        return view('avored::order.order.index')
            ->with('orders', $orderes);
    }
}