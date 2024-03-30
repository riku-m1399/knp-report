<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function promoter(){
        return $this->belongsTo(User::class, 'promoter_id');
    }

    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }

}
