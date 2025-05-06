<?php

namespace App\Models\RS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item\Itemdetail;
use App\Models\Item\Itemmaster;
use App\Models\RS\RSMaster;

class RSItem extends Model
{
    use HasFactory;
    protected $table='rs_items';
    protected $guarded=['id'];

    public function rs_master()
    {
        $this->belongsTo(RSMaster::class);
    }

    public function item_detail()
    {
        $this->hasMany(Itemdetail::class);
    }

    public function item_master()
    {
        $this->hasMany(Itemmaster::class);
    }


}
