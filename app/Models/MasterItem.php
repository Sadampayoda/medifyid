<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'kode',
        'nama',
        'harga_beli',
        'laba',
        'supplier',
        'jenis',
        'image',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            CategoryItem::class,
            'item_category_syncs',
            'item_id',
            'category_id'
        )->withTimestamps();
    }
}
