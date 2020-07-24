<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'table_payments';
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
        return $this->belongsTo('App\Order');
    }
}
