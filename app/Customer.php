<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'table_customers';
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

    public function order()
    {
        return $this->hasMany('App\Order');
    }
}
