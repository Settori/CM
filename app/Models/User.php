<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Duty;
use App\Models\Point;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function getDutiesAttribute() {
        $duties = [];
        foreach(Duty::with(['points' => function($q) use (&$duties) {
            $q->where('points.user_id', $this->id);
        }])->get() as $d) {
            $duties[] = [
                'name' => $d->name,
                'value' => $d->value,
                'count' => $d->points->count()
            ];
        }
        return $duties;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
