<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameEntry extends Model
{
    use HasFactory;

    protected $table = 'game_user';
    public static $statusEnum = ['Played', 'Playing', 'Plan to play', 'On hold', 'Dropped'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
