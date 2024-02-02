<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'company_id'];
    protected $date = ['deleted_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}