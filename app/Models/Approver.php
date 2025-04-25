<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'rs_approver';
    protected $fillable = [
        'nik',
        'role',
        'level',
    ];
}
