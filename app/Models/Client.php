<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'address', 'phone'
    ];
    protected $casts = [
//      'phone'=>'array'
    ];

    /*
     * Scopes
     *
     * */

    public function scopeFilterByName($query, $searchQuery)
    {
        return $query->where('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('email', 'like', '%' . $searchQuery . '%')
            ->orWhere('address', 'like', '%' . $searchQuery . '%')
            ->orWhere('phone', 'like', '%' . $searchQuery . '%');
    }

    /*
     * Accessors
     *
     * */

    public function getPhoneAttribute($value)
    {
        return explode(',', $value);
    }

    /*
     * Mutators
     *
     * */

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = implode(',', array_filter($value));
    }

    /*
     * Relations
     *
     * */

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }
}
