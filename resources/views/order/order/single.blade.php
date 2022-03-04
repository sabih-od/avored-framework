<x-avored::layout>
<div>
    <div class="p-5">
        <div class="flex w-full">
            <h2 class="text-2xl text-red-700 font-semibold">
                {{ __('avored::system.order') }} {{ __('avored::system.list') }}
            </h2>
        </div>

        <div class="w-full mt-5">

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

                            </x-avored::table.row>
                        @endforeach
                    </x-slot>
                </x-avored::table>
                <div class="w-full">
                    {{ $orders->render() }}
                </div>
            </div>

            <h2 class="text-red-700 font-semibold">Product Infromation</h2>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qunatity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if(count($order->products) > 0)
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{$product->product->name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{(float)$product->product->price}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{(int)$product->qty}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">$ {{ (float)($product->qty * $product->product->price) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            
            <h2 class="text-red-700 font-semibold">Customer Information</h2>
            <div>
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billing Address</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping Address</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->customer->first_name}} {{$order->customer->last_name}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->customer->email}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->billingAddress->address1}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{$order->shippingAddress->address1}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</x-avored::layout>
