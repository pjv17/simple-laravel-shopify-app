<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Created Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12 created-products">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($created_products)
                        <div class="created-prod-details py-4">
                            <h3 class="text-xl">Products Created: <strong>{{ count($created_products) }}</strong></h3>
                            <div class="flex flex-row">
                                <h3 class="text-xl">Date:
                                    <strong>{{ date('Y-m-d', strtotime($product_lists->date_time_updated)) }}</strong>
                                </h3>
                                <h3 class="ml-4 text-xl">Time:
                                    <strong>{{ date('H:i', strtotime($product_lists->date_time_updated)) }}</strong>
                                </h3>
                            </div>
                        </div>
                        <table class="table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Title</th>
                                    <th scope="col" class="px-6 py-3">SKU</th>
                                    <th scope="col" class="px-6 py-3">Vendor</th>
                                    <th scope="col" class="px-6 py-3">Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($created_products as $product)
                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        <td scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $product['title'] }}</td>
                                        <td class="px-6 py-4">{{ $product['variants'][0]['sku'] }}</td>
                                        <td class="px-6 py-4">{{ $product['vendor'] }}</td>
                                        <td class="px-6 py-4">{{ $product['product_type'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
