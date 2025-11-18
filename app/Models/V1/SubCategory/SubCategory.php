<?php

namespace App\Models\V1\SubCategory;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
    ];

    /**
     * Get the category that owns the sub-category.
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\V1\Category\Category::class);
    }
}
