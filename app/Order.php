<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'table_orders';
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

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function order_item()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment');
    }
}
