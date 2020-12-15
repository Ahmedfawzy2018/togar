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

    public function parent() // relation will be to get the parent category of a category
	{
	    return $this->belongsTo(Category::class, 'parent_id');
	}

	public function children() //for our category to return the children for our given category.
	{
	    return $this->hasMany(Category::class, 'parent_id');
	}
}
