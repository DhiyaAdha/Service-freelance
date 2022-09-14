<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatus extends Model
{
     // use HasFactory;
    use SoftDeletes;
    
    public $table = 'order_status';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name', 
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // one to many
    public function order()
    {
        return $this->hasMany('App\Models\Order', 'order_status_id');
    }

}
