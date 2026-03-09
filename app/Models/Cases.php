<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    protected $fillable = ['title', 'date_filed', 'status', 'latest_date_of_entry'];
     protected $casts = [
        'date_filed' => 'date',
        'latest_date_of_entry' => 'date',
    ];
}
