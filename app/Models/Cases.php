<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FiscalYear;

class Cases extends Model
{
    protected $fillable = ['title', 'date_filed', 'status', 'latest_date_of_entry', 'year_id'];

     protected $casts = [
        'date_filed' => 'date',
        'latest_date_of_entry' => 'date',
    ];
     public function year()
        {
            return $this->belongsTo(FiscalYear::class, 'year_id');
        }
}
