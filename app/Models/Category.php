<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

    protected $table = 'categories';
    protected $softDelete = true;

    protected $fillable = [
        'parent_id','name', 'description','status', 
    ];

    protected $casts = [
        'parent_id' =>  'integer',
    ];

}
