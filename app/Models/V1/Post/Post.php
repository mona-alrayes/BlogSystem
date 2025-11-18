<?php

namespace App\Models\V1\Post;

use App\Enums\StatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'sub_category_id',
        'status',
    ];

    // Store status as a simple string in the database. We provide
    // accessor/mutator to accept enum instances and always return
    // the backed string when accessed/serialized.
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the author that owns the post.
     */
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Alias to `author()` kept for compatibility.
     */
    public function user()
    {
        return $this->author();
    }

    /**
     * Ensure status is returned as its backed string when accessed or serialized.
     */
    public function getStatusAttribute($value)
    {
        return $value;
    }

    /**
     * Accept either a StatusType enum or a raw string and store the
     * backed string value in the database.
     */
    public function setStatusAttribute($value)
    {
        if ($value instanceof StatusType) {
            $this->attributes['status'] = $value->value;
            return;
        }

        $this->attributes['status'] = $value;
    }

    /**
     * Get the sub-category that owns the post.
     */
    public function subCategory()
    {
        return $this->belongsTo(\App\Models\V1\SubCategory\SubCategory::class, 'sub_category_id');
    }

}
