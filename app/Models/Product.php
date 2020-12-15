<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category ;
class Product extends Model
{
    use HasFactory;

   	protected $table = "product"; 
    protected $fillable = [
    	'category_id','name', 'price','image','description','quantity_available','in_stock','status', 
    ];
    protected $softDelete = true;
         
    public function categories() //for our category to return the children for our given category.
	{
	    return $this->belongsTo(Category::class, 'category_id');
	}        
}
