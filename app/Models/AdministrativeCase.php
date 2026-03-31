<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AdministrativeReport;

class AdministrativeCase extends Model
{
    protected $fillable = [
        'name',
        'station',
        'docket_no',
        'nature',
        'status',
        'report_title'
    ];

    public function report()
    {
        return $this->belongsTo(AdministrativeReport::class, 'report_id');
    }
}
