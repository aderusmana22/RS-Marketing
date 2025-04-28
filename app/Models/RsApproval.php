<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsApproval extends Model
{
    use HasFactory;

    protected $table = 'rs_approvals';

    protected $fillable = [
        'nik', 'role', 'level','status','token',
    ];


}
