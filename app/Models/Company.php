<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'size', 'location'];
    protected $dates = ['deleted_at'];

    public function adverts()
    {
        return $this->hasMany(Advert::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function (Company $company) {
            $company->adverts()->delete();
        });
    }
}