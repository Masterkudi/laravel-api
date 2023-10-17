<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    // una categoria può essere usata in molti progetti
    public function projects() {
        return $this->hasMany(Project::class);
    }
}
