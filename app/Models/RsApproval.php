<?php

namespace App\Models;

use App\Models\RS\RSMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsApproval extends Model
{
    use HasFactory;

    protected $table = 'rs_approvals';

    protected $fillable = [
        'rs_no', 'nik','level','status','token',
    ];

    public function rsMaster()
    {
        return $this->belongsTo(RSMaster::class, 'rs_no', 'rs_no');
    }


}
