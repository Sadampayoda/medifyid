<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemCategorySync extends Pivot
{
    use HasFactory;

    protected $table = 'item_category_syncs';

    protected $fillable = [
        'item_id',
        'category_id',
    ];
}
