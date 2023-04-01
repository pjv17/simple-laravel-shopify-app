<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class ProductListsController extends Controller
{
    public function index()
    {
        return view('dashboard.product-lists');
    }

    public function getShopifyAPI()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => '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',
        ])->get('https://the-cut-candidates-store.myshopify.com/admin/api/2023-01/products.json');

        return $response->json()['products'];
    }

    public function getProductCreated($id)
    {
        $get_updated_product = DB::table('product_list')->get()->where('id', 1)->first();
        $get_current_product_ids = unserialize($get_updated_product->created_products);
        $implode_prod_ids = implode(",", $get_current_product_ids);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => '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',
        ])->get('https://the-cut-candidates-store.myshopify.com/admin/api/2023-01/products.json', [
                'ids' => $implode_prod_ids,
            ]);

        return view('dashboard.product-lists.created', ['created_products' => $response->json()['products'], 'product_lists' => $get_updated_product]);

    }

    public function getProductUpdated($id)
    {
        $get_updated_product = DB::table('product_list')->get()->where('id', 1)->first();
        $get_current_product_ids = unserialize($get_updated_product->created_products);
        $implode_prod_ids = implode(",", $get_current_product_ids);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => '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',
        ])->get('https://the-cut-candidates-store.myshopify.com/admin/api/2023-01/products.json', [
                'ids' => $implode_prod_ids,
            ]);

        return view('dashboard.product-lists.updated', ['updated_products' => $response->json()['products'], 'product_lists' => $get_updated_product]);

    }

    public function getAllProductLists()
    {
        $product_lists = DB::table('product_list')->orderBy('id', 'desc')->get();
        $shopify_products = $this->getShopifyAPI();
        return view('dashboard.product-lists', ['last_check_details' => $product_lists, 'shopify_products' => $shopify_products]);
    }
    public function storeProductLists(Request $request)
    {
        $product_lists = DB::table('product_list')->orderBy('id', 'desc')->get()->first();
        $get_shopify_products = $this->getShopifyAPI();

        if ($product_lists) {
            $product_lists = $product_lists['date_time_updated'];
        } else {
            $product_lists = "1990-02-13 01:00";
        }

        date_default_timezone_set('Australia/Perth');
        $get_current_date = date('Y-m-d H:i:s');
        $get_last_check_date = date('Y-m-d H:i:s', strtotime($product_lists));
        $updated_prod_ids = [];
        $created_prod_ids = [];
        foreach ($get_shopify_products as $data) {
            $str_replace_updated_date = str_replace(["T", "+08:00"], [" ", ""], $data['updated_at']);
            $str_replace_created_date = str_replace(["T", "+08:00"], [" ", ""], $data['created_at']);
            $prod_updated_date = date("Y-m-d H:i:s", strtotime($str_replace_updated_date));
            $prod_created_date = date("Y-m-d H:i:s", strtotime($str_replace_created_date));

            if ($prod_updated_date > $get_last_check_date) {
                $updated_prod_ids[] = $data['id'];
            }
            if ($prod_created_date > $get_last_check_date) {
                $created_prod_ids[] = $data['id'];
            }
        }

        $insert_data = array(
            'date_time_updated' => $get_current_date,
            'updated_products' => serialize($updated_prod_ids),
            'created_products' => serialize($created_prod_ids),
            'created_at' => $get_current_date,
            'updated_at' => $get_current_date,
        );

        $queryState = DB::table('product_list')->insert($insert_data);

        if ($queryState) {
            $status = 'success';
        } else {
            $status = 'failed';
        }
        return redirect()->back()->with('status', $status);
    }
}