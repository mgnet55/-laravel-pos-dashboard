<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'image'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'image_path'
    ];


    /* Scopes */

    public function scopeFilterByName($query, $searchQuery)
    {
        return $query
            ->where('first_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('last_name', 'like', '%' . $searchQuery . '%');
    }


    /* Accessors */

    public function getFirstNameAttribute($value): string
    {
        return ucwords($value);
    }

    public function getLastNameAttribute($value): string
    {
        return ucwords($value);
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /* Permissions names Array */
    public function getPermissionsAttribute(): array
    {
        return $this->allPermissions(['name'])->pluck('name')->toArray();
    }

    public function getImagePathAttribute(): string
    {
        return $this->image ?
            asset('uploads/user-images/' . $this->image)
            :
            "https://fakeimg.pl/250x250/?text=NO-IMAGE";
    }

    public function setImageAttribute($value)
    {
        //If image has a value then delete old image from disk
        if ($imgName = $this->image)
            Storage::disk('local')->delete('uploads/user-images/' . $imgName);
        // set new value or null for empty
        $this->attributes['image'] = $value ?: null;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
