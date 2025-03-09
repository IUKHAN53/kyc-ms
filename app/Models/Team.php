<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'supervisor_id',
        'daily_goal',
        'monthly_goal',
    ];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user');
    }
}
