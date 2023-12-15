<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameEntry extends Model
{
    use HasFactory;

    // tells laravel to refer to the "game_user" table for this model
    protected $table = 'game_user';

    // defines the enum for use elsewhere
    public static $statusEnum = ['Played', 'Playing', 'Plan to play', 'On hold', 'Dropped'];

    // each entry belongs to one game
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
