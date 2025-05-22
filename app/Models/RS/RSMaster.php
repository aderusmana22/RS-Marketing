<?php

namespace App\Models\RS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RS\RSItem;
use App\Models\Revisions;
use App\Models\User;

class RSMaster extends Model
{
    use HasFactory;
    protected $table='rs_masters';
    protected $guarded=['id'];


    public function rs_items()
    {
        return $this->hasMany(RSItem::class, 'rs_id');
    }

    public function revisions()
    {
        return $this->belongsTo(Revisions::class);
    }

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_nik', 'nik');
    }
}
