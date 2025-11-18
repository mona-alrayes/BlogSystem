<?php

namespace App\Models\V1\Category;

use Illuminate\Database\Eloquent\Model;
use App\Models\V1\SubCategory\SubCategory;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'description'];
    
    /**
     * Get the sub-categories for the category.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
