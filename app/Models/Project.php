<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'body',
        'image',
        'repository',
        'slug',
        'user_id',
        'type_id',
    ];

    
    public function user() {
        return $this->belongsTo(User::class);
    }

    // un progetto appartiene ad una sola categoria
    public function type() {
        return $this->belongsTo(Type::class);
    }

    // nelle technologies creo il collegamento per il project
    public function technologies() {
        return $this->belongsToMany(Technology::class);
    }
}
