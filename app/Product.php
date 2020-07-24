<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'table_products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function order_item()
    {
        return $this->hasMany('App\OrderItem');
    }
}
