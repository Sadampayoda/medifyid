<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public static function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public static function ruleMessages()
    {
        return [
            'code.required' => 'Kode Wajib Diisi',
            'name.required' => 'Nama Wajib Diisi',
        ];
    }

    public function items()
    {
        return $this->belongsToMany(
            MasterItem::class,
            'item_category_syncs',
            'category_id',
            'item_id'
        )->withTimestamps();
    }
}
