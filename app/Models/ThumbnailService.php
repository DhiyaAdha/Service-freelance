<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThumbnailService extends Model
{
    // use HasFactory;
    use SoftDeletes;
    
    public $table = 'thumbnail_service';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'service_id', 
        'thumbnail',
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
