<x-avored::layout>
<div>
    <div class="p-5">
        <div class="flex w-full">
            <h2 class="text-2xl text-red-700 font-semibold">
                {{ __('avored::system.order') }} {{ __('avored::system.list') }}
            </h2>
        </div>

        <div class="w-full mt-5">

            <form action="{{ route('admin.order.filter') }}" method="POST">
                @csrf <!-- {{ csrf_field() }} -->
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="flex w-full">
                        <input 
                            class="mr-2 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" 
                            type="text" 
                            placeholder="Order Id"
                            name="order_id">
                        
                        <input class="mr-2 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" 
                            type="text" 
                            placeholder="Name"
                            name="name">

                        <input class="mr-2 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" 
                            type="text" 
                            placeholder="Email"
                            name="email">

                        <select name="order_status" class="mr-2 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white" >
                            <option value="">Select Status</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="pending">Pending</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>
                    <div class="flex w-full mt-3">
                        <input 
                            class="mr-2 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" 
                            type="date" 
                            placeholder="Date From"
                            name="date_from">
                        <input 
                            class="mr-2 appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" 
                            type="date" 
                            placeholder="Date To"
                            name="date_to">

                        <button type="submit" class="shadow bg-red-500 hover:bg-red-600 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded">Filter</button>
                    </div>
                </div>
            </form>

            <!-- component -->
            <div class="overflow-x-auto">
                <x-avored::table>
                    <x-slot name="header">
                        <x-avored::table.row class="bg-gray-300">
                            <x-avored::table.header>
                                Order Id
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Name
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Email
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Order Status
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Order Total
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Order Date
                            </x-avored::table.header>
                            <!-- <x-avored::table.header>
                                {{ __('avored::system.shipping_option') }}
                            </x-avored::table.header> -->
                            <x-avored::table.header>
                                {{ __('avored::system.payment_option') }}
                            </x-avored::table.header>
                            

                            <x-avored::table.header class="rounded-tr">
                                {{ __('avored::system.actions') }}
                            </x-avored::table.header>
                        </x-avored::table.row>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($orders as $order)
                            <x-avored::table.row class="{{ ($loop->index % 2 == 0) ? '' : 'bg-gray-200'  }}">
                                <x-avored::table.cell>
                                    {{ $order->id ?? '' }}
                                </x-avored::table.cell>
                                
                                <x-avored::table.cell>
                                    {{ $order->customer->first_name ?? '' }} {{ $order->customer->last_name ?? '' }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    {{ $order->customer->email ?? '' }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    {{ $order->orderStatus->name ?? '' }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    @php
                                        $total = 0;
                                        $product_array = [];
                                        if(count($order->products) > 0) {
                                            foreach( $order->products ?? [] as $product ) {
                                                $product_price_array[] = $product->price * $product->qty;
                                                $total = array_sum($product_price_array);
                                            }
                                        }
                                    @endphp
                                    ${{ $total }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    {{ $order->created_at ?? '' }}
                                </x-avored::table.cell>

                                <!-- <x-avored::table.cell>
                                    {{ $order->shipping_option ?? '' }}
                                </x-avored::table.cell> -->
                               
                                <x-avored::table.cell>
                                    {{ $order->payment_option ?? '' }}
                                </x-avored::table.cell>
                               

                                <x-avored::table.cell>
                                    <div class="flex">
                                        <x-avored::link url="{{ route('admin.order.show', $order) }}">
                                            <i class="w-5 h-5" data-feather="eye"></i>
                                        </x-avored::link>

                                        <style>
                                            .group_status {
                                                display: flex;
                                                margin-left: 15px;
                                            }
                                            .group_status input[type="radio"] {
                                                display: none;
                                            }
                                            .group_status > div > .group_label {
                                                background-color: #757678!important;
                                                color: #fff;
                                                padding: 5px 10px;
                                                cursor: pointer;
                                            }
                                            .group_status > div > input[type="radio"]:checked ~ .group_label {
                                                background-color: #374151!important;
                                            }
                                            .classic_anchor {
                                                background-color: #757678!important;
                                                color: #fff;
                                                padding: 5px 10px;
                                                cursor: pointer;
                                            }
                                            
                                        </style>

                                        <form action="{{ route('admin.order.status') }}" method="POST">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="group_status">
                                                <input type="hidden" name="status" value="pending" />
                                                <input type="hidden" name="order_id" value="{{$order->id}}" />
                                                <button class="classic_anchor" type="submit">Pending</button>
                                            </div>
                                        </form>

                                        <form action="{{ route('admin.order.status') }}" method="POST">
                                            @csrf <!-- {{ csrf_field() }} -->
                                            <div class="group_status">
                                                <input type="hidden" name="status" value="complete" />
                                                <input type="hidden" name="order_id" value="{{$order->id}}" />
                                                <button class="classic_anchor" type="submit">Complete</button>
                                            </div>
                                        </form>

                                    </div>
                                </x-avored::table.cell>
                            </x-avored::table.row>
                        @endforeach
                    </x-slot>
                </x-avored::table>
                <div class="w-full">
                    {{ $orders->render() }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-avored::layout>
