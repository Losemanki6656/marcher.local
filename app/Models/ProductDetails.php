<?php

namespace App\Models;

use App\Casts\Hash;
use App\Models\BaseModel;
use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;

class ProductDetails extends BaseModel
{
    protected $table = 'product_details';

    protected $default = ['xid'];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['id', 'warehouse_id', 'product_id', 'tax_id'];

    protected $appends = ['xid', 'x_warehouse_id', 'x_product_id', 'x_tax_id'];

    protected $filterable = ['id'];

    protected $hashableGetterFunctions = [
        'getXWarehouseIdAttribute' => 'warehouse_id',
        'getXProductIdAttribute' => 'product_id',
        'getXTaxIdAttribute' => 'tax_id',
    ];

    protected $casts = [
        'warehouse_id' => Hash::class . ':hash',
        'product_id' => Hash::class . ':hash',
        'tax_id' => Hash::class . ':hash',
        'current_stock' => 'double',
        'mrp' => 'double',
        'sales_price' => 'double',
        'stock_quantitiy_alert' => 'double',
        'opening_stock' => 'double',
        'wholesale_price' => 'double',
        'wholesale_quantity' => 'double',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new CompanyScope);

        static::addGlobalScope('current_warehouse', function (Builder $builder) {
            $warehousePath = request()->path();
            $warehousePathArray = $warehousePath != '' ? explode('/', $warehousePath) : [];

            if ($warehousePathArray && isset($warehousePathArray[0]) && $warehousePathArray[0] == 'store' && isset($warehousePathArray[1])) {
                $warehouseSlug = $warehousePathArray[1];
                $warehouse = Warehouse::withoutGlobalScope(CompanyScope::class)
                    ->where('slug', $warehouseSlug)
                    ->first();
                if ($warehouse) {
                    $builder->where('product_details.warehouse_id', $warehouse->id);
                }
            } else {
                $warehouse = warehouse();

                if ($warehouse) {
                    $builder->where('product_details.warehouse_id', $warehouse->id);
                }
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
