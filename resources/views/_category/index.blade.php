<x-avored::layout>
<div>
    <div class="p-5">
        <div class="flex w-full">
            <h2 class="text-2xl text-red-700 font-semibold">
                Recipes
            </h2>
            <span class="ml-auto">
                <x-avored::link url="{{ route('admin.new_category.create') }}" style="button-primary">
                    Create
                </x-avored::link>
            </span>
        </div>

        <div class="w-full mt-5">
        {{ $_categories->render() }}
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
>>>>>>> origin/hotfix
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
                                Name
                            </x-avored::table.header>
                            <x-avored::table.header class="rounded-tr">
                                Actions
                            </x-avored::table.header>
                        </x-avored::table.row>
                    </x-slot>
                    <x-slot name="body">
                        @foreach ($_categories as $_category)
                            <x-avored::table.row class="">
                                <x-avored::table.cell>
                                    {{ $_category->name }}
                                </x-avored::table.cell>

                                <x-avored::table.cell>
                                    <div class="flex">
                                        <x-avored::link url="{{ route('admin.new_category.edit', $_category) }}">
                                            <i class="fa fa-pencil"></i>
                                        </x-avored::link>
                                        <x-avored::form.form action="{{ route('admin.new_category.destroy', $_category) }}"
                                                             method="DELETE">
                                            <button class=" ml-3"
                                                    type="submit"><i class="fa fa-trash"></i>
                                            </button>
                                        </x-avored::form.form>
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
