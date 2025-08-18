<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductImage;
use Spatie\Sluggable\HasSlug;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasSlug;
    use SoftDeletes;
    use HasFactory;
    use HasApiTokens;
    protected $fillable = ['title', 'description', 'price','image_mime', 'image_size','published', 'created_by', 'updated_by'];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function getImageAttribute()
    {
        return $this->images->count() > 0 ? $this->images->get(0)->url : null;
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
