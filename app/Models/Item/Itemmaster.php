<?php

namespace App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemmaster extends Model
{
    use HasFactory;

    protected $table='item_masters';
    protected $guarded=['id'];

    public function item_details()
    {
        $this->hasMany(Itemdetail::class);
    }
}
