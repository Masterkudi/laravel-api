<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    // la funzione user rappresenta un dettaglio appartiene ad un solo utente
    public function user() {
        return $this->belongsTo(User::class);
    }
}