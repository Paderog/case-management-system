<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdministrativeCase;

class AdministrativeReport extends Model
{
    protected $fillable = ['report_title'];

    public function cases()
    {
        return $this->hasMany(AdministrativeCase::class, 'report_id');
    }
}