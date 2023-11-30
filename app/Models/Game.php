<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    // each game has one publisher
    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class);
    }

    // each game belongs to many genres
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    // each game can be on many users' lists
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
