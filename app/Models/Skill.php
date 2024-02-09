<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    /**
     * The adverts that belong to the skill.
     */
    public function adverts()
    {
        return $this->belongsToMany(Advert::class, 'adverts_skills');
    }

    /**
     * The users that belong to the skill.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_skills');
    }
}