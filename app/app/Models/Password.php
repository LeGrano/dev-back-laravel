<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class password extends Model
{

    use HasFactory;
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_password');
    }
}
