<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // each user can have many games on their list
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

    // each user has many roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    // checks if a user has a specific role
    public function hasRole($role)
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    // checks if a user has any role in an array
    public function hasAnyRole($roles)
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    // use examples
    // $user->authorizeRoles('admin');
    // $user->authorizeRoles(['admin', 'editor']);
    public function authorizeRoles($roles)
    {
        if(is_array($roles))
        {
            return $this->hasAnyRole($roles) || abort(403, "You are not authorized!"); 
        }

        return $this->hasRole($roles) || abort(403, "You are not authorized!"); 
    }
}
