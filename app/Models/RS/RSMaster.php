<?php

namespace App\Models\RS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RSMaster extends Model
{
    use HasFactory;
    protected $table='rs_masters';
    protected $guarded=['id'];


    public function rs_items()
    {
        $this->hasMany(RSItem::class, 'rs_id');
    }

    public function revisions()
    {
        $this->hasMany(Revisions::class);
    }
}
