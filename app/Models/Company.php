<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'size', 'location'];
    protected $dates = ['delete_at'];
    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }


}