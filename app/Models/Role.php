<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model
{
    public function users(): BelongsToMany{
    return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id');
}

}
