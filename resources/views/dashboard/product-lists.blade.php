<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product Lists') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('status') && session('status') == 'success')
                        <div class="status-success"></div>
                    @endif
                    <form method="POST">
                        @csrf
                        <input type="submit" name="check-update"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            value="Check Update">
                    </form>
                    @if ($last_check_details->isEmpty())
                        <h2>{{ __('No Results') }}</h2>
                    @else
                        <table class="table-fixed w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-sm text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-">Date</th>
                                    <th scope="col" class="px-6 py-3">Time</th>
                                    <th scope="col" class="px-6 py-3">Created</th>
                                    <th scope="col" class="px-6 py-3">Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($last_check_details as $detail)
                                    <?php
                                    $format_date = date('Y-m-d', strtotime($detail->date_time_updated));
                                    $format_time = date('H:i', strtotime($detail->date_time_updated));
                                    $updated_prod_ids = unserialize($detail->updated_products);
                                    $created_prod_ids = unserialize($detail->created_products);
                                    $count_updated_prod = 0;
                                    $count_created_prod = 0;
                                    if (is_array($updated_prod_ids)) {
                                        $count_updated_prod = count($updated_prod_ids);
                                    }
                                    if (is_array($created_prod_ids)) {
                                        $count_created_prod = count($created_prod_ids);
                                    }
                                    ?>
                                    <tr>
                                        <td>{{ $format_date }}</td>
                                        <td>{{ $format_time }}</td>
                                        <td><a href="<?php echo url('/') . '/dashboard/product-lists/created/' . $detail->id; ?>"><?php echo $count_created_prod; ?></a></td>
                                        <td><a href="<?php echo url('/') . '/dashboard/product-lists/updated/' . $detail->id; ?>"><?php echo $count_updated_prod; ?></a></td>
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
