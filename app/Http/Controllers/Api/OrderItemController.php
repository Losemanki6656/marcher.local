<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiBaseController;
use App\Http\Requests\Api\OrderItem\IndexRequest;
use App\Models\OrderItem;

class OrderItemController extends ApiBaseController
{
    protected $model = OrderItem::class;

    protected $indexRequest = IndexRequest::class;

    public function modifyIndex($query)
    {
        $request = request();
        $warehouse = warehouse();

        $query = $query->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.warehouse_id', $warehouse->id);

        // Dates Filters
        if ($request->has('dates') && $request->dates != "") {
            $dates = explode(',', $request->dates);
            $startDate = $dates[0];
            $endDate = $dates[1];

            $query = $query->whereRaw('orders.order_date >= ?', [$startDate])
                ->whereRaw('orders.order_date <= ?', [$endDate]);
        }

        if ($request->has('product_sales_summary') && $request->product_sales_summary) {
            $this->modifySelect = true;

            $query = $query->join('products', 'products.id', '=', 'order_items.product_id')
                ->where('orders.order_type', 'sales')
                ->groupBy('order_items.product_id')
                ->selectRaw("order_items.product_id,sum(order_items.quantity) as unit_sold")
                ->with('product:id,name,item_code,image,unit_id', 'product.unit:id,name,short_name');
        }

        return $query;
    }
}