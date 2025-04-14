<?php

namespace App\Models\RS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RSInitiator extends Model
{
    use HasFactory;
    protected $table='initiator_approvals';
    protected $guarded=['id'];

    public function rs_master()
    {
        $this->hasMany(RSMaster::class);
    }
}
