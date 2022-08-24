<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'sell_price', 'purchase_price', 'stock', 'category_id', 'image'
    ];
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];

    protected $hidden = [
        'image'
    ];

    protected $appends = [
        'image_path'
    ];

    /*
     *  Relations
     *
     */

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withTimestamps();
    }

    /*
     *  Scopes
     *
     */

    public function scopeFilterByName($query, $searchQuery)
    {
        $locales = LaravelLocalization::getSupportedLanguagesKeys();

        $query->where('name->' . array_shift($locales), 'like', '%' . $searchQuery . '%');

        foreach ($locales as $locale) {
            $query->orWhere('name->' . $locale, 'like', '%' . $searchQuery . '%');
        }
        return $query;
    }

    public function scopeFilterByCategory($query, $category_id)
    {
        return $query->whereCategoryId($category_id);
    }

    /*
     * Accessors
     *
     */

    public function getImagePathAttribute(): string
    {
        return $this->image ?
            asset('uploads/product-images/' . $this->image)
            :
            "https://fakeimg.pl/250x250/?text=NO-IMAGE";
    }

    public function getLocalizedNameAttribute(): string
    {
        return $this->name[app()->getLocale()];
    }

    /*
     * Mutators
     *
     */

    public function setImageAttribute($value)
    {
        //If image has a value then delete old image from disk
        if ($imgName = $this->image)
            Storage::disk('local')->delete('uploads/product-images/' . $imgName);
        // set new value or null for empty
        $this->attributes['image'] = $value ?: null;
    }
}
