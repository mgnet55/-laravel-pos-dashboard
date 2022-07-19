<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'array',
    ];

    /* Relations */
    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    /* Scopes */

    public function scopeFilterByName($query, $searchQuery)
    {
        $locales = LaravelLocalization::getSupportedLanguagesKeys();

        $query->where('name->' . array_shift($locales), 'like', '%' . $searchQuery . '%');

        foreach ($locales as $locale) {
            $query->orWhere('name->' . $locale, 'like', '%' . $searchQuery . '%');
        }
        return $query;
    }
}
