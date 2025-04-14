<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemdetail extends Model
{
    use HasFactory;
    protected $table='item_details';
    protected $guarded=['id'];

    public function item_masters()
    {
        $this->belongsTo(Itemmaster::class);
    }
}
