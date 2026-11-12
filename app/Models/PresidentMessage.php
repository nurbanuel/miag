<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresidentMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'president_name',
        'president_title',
        'image',
        'content',
    ];
}
