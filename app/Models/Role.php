<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    /**
     * questa funzione è primaria e collega Users e ritorna hasMany
     * per il fatto che ci sono molti users per un role
     */
    public function users() {
        return $this->hasMany(Users::class);
    }
}
