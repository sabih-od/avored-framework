<x-avored::layout>
<div>
    <div class="p-5">
        <div class="flex w-full">
            <h2 class="text-2xl text-red-700 font-semibold">
                Recipes
            </h2>
            <span class="ml-auto">
                <x-avored::link url="{{ route('admin.recipe.create') }}" style="button-primary">
                    Create
                </x-avored::link>
            </span>
        </div>

        <div class="w-full mt-5">
        {{ $recipes->render() }}
            <!-- <form action="{{ route('admin.order.filter') }}" method="POST"> -->
                <!-- @csrf  -->
                <!-- {{ csrf_field() }} -->
                <!-- <div class="flex flex-wrap -mx-3 mb-6">
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
                </div> -->
            <!-- </form> -->

            <!-- component -->
            <div class="overflow-x-auto">
                <x-avored::table>
                    <x-slot name="header">
                        <x-avored::table.row class="bg-gray-300">
                            <x-avored::table.header>
                                Recipe Id
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Created By
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Name
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Image
                            </x-avored::table.header>
                            <x-avored::table.header>
                                Approved
                            </x-avored::table.header>
                            <x-avored::table.header class="rounded-tr">
                                Actions
                            </x-avored::table.header>
                        </x-avored::table.row>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($recipes as $recipe)
                            <x-avored::table.row class="">
                                <x-avored::table.cell>
                                    {{ $recipe->id }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    {{ $recipe->user->name ?? 'Admin' }}
                                </x-avored::table.cell>
                                
                                <x-avored::table.cell>
                                    {{ $recipe->name }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    <img class="w-10" src="{{ $recipe->media_upload['url'] ?? '' }}" alt="" />
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    {{ $recipe->is_approved ? 'Yes' : 'No' }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    <div class="flex">
                                        <x-avored::link url="{{ route('admin.recipe.edit', $recipe) }}">
                                            <i class="fa fa-pencil"></i>
                                        </x-avored::link>

                                    
                                    <!--
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
                                            @csrf 
                                            <div class="group_status">
                                                <input type="hidden" name="status" value="pending" />
                                                <input type="hidden" name="order_id" value="" />
                                                <button class="classic_anchor" type="submit">Pending</button>
                                            </div>
                                        </form>

                                        <form action="{{ route('admin.order.status') }}" method="POST">
                                            @csrf
                                            <div class="group_status">
                                                <input type="hidden" name="status" value="complete" />
                                                <input type="hidden" name="order_id" value="" />
                                                <button class="classic_anchor" type="submit">Complete</button>
                                            </div>
                                        </form>
                                    -->
                                    </div>
                                </x-avored::table.cell>

                            </x-avored::table.row>
                        @endforeach
                    </x-slot>
                </x-avored::table>
                <div class="w-full">
                   
                </div>
            </div>
        </div>
    </div>
</div>
</x-avored::layout>
