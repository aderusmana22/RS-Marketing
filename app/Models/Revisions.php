<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revisions extends Model
{
    use HasFactory;
    protected $fillable = [
        'form_no', 'revision', 'date'
    ];


}
