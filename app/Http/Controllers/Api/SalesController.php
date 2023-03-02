<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    
    public function saveLocalSales(Request $request){
      
    //   return $request->all();
 foreach ($request->all() as $key => $value) {
      DB::table('mauzos')->insert([
            'product_id' => $value['product_id'],
            'seller_id' => $value['seller_id'],
            'owner_id' => $value['owner_id'],
            'shop_id' => $value['shop_id'],
            'day' => $value['day'],
            'month' => $value['month'],
            'year' => $value['year'],
            'sales_date' => $value['sales_date'],
            'quantity' => $value['quantity'],
            'amount' => $value['amount'],
            'sold_price' => $value['sold_price'],
            'true_price' => $value['true_price'],
            'discount' => $value['discount'],
            'profit' => $value['profit'],
            'customer_name' => $value['customer_name'],
            'sale_status' => $value['sale_status']
        ]);
 }
    return "Success";    
         
    }
}
