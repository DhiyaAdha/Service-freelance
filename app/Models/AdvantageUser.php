<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvantageUser extends Model
{
    // use HasFactory;
    use SoftDeletes;
    
    public $table = 'advantage_user';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id', 
        'advantage',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // one to many
    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }

}
