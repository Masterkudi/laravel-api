<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
     * Quando si recupera i dati degli utenti tramite API la password verrà nascosta
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

    
    public function projects() {
        return $this->hasMany(Project::class);
    }

    // la funzione userDetail rappresenta un solo dettaglio per ogni utente
    public function userDetail() {
        return $this->hasOne(userDetail::class);
    }

    /**
     * questa funzione è secondaria e collega Role e ritorna belongsTo
     * per il fatto che c'è un solo role per ogni user
     */
     public function role() {
        return $this->belongsTo(Role::class);
     }
}
